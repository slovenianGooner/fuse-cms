<?php

use App\DTO\Admin\Table\Action;
use App\Enum\Modal;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public ?User $user = null;

    #[Computed]
    public function users(): LengthAwarePaginator
    {
        return User::latest()->with('roles')->paginate(10);
    }

    public function actions(User $user): Collection
    {
        $actions = collect();

        if ($user->isSuperAdmin()) {
            return $actions;
        }

        if (auth()->user()->can('update', $user)) {
            $actions->push(new Action('edit', __('Edit'), 'pencil-square'));
        }

        if (auth()->user()->can('impersonate', $user)) {
            $actions->push(new Action('impersonate', __('Impersonate'), 'hat-glasses'));
        }

        if (auth()->user()->can('delete', $user)) {
            $actions->push('separator');
            $actions->push(new Action('confirmDelete', __('Delete'), 'trash'));
        }

        return $actions;
    }

    public function edit(User $user): void
    {
        if (auth()->user()->cannot('update', $user)) {
            abort(403);
        }

        $this->user = $user;
        $this->modal(Modal::EDIT_USER)->show();
    }

    public function impersonate(User $user): void
    {
        if (auth()->user()->cannot('impersonate', $user)) {
            abort(403);
        }

        $this->redirect(route('admin.impersonate', $user->id));
    }

    public function confirmDelete(User $user): void
    {
        if (auth()->user()->cannot('delete', $user)) {
            abort(403);
        }

        $this->user = $user;
        $this->modal(Modal::CONFIRM)->show();
    }

    public function delete(): void
    {
        $this->user->delete();
        $this->reset('user');
    }
};
?>

<div class="p-6 max-w-screen-lg h-full overflow-hidden flex flex-col">

    <div class="relative mb-2 w-full flex justify-between items-end">
        <flux:heading size="xl" level="1">{{ __('Users') }}</flux:heading>
        @can('create', User::class)
            <flux:modal.trigger name="{{ Modal::CREATE_USER }}">
                <flux:button variant="primary" size="sm" icon="plus">{{ __('Create') }}</flux:button>
            </flux:modal.trigger>
        @endcan
    </div>

    <x-table :paginate="$this->users" class="flex-1">
        <x-table.columns>
            <x-table.column>{{ __('Name') }}</x-table.column>
            <x-table.column>{{ __('E-mail') }}</x-table.column>
            <x-table.column>{{ __('Roles') }}</x-table.column>
            <x-table.column></x-table.column>
        </x-table.columns>
        <x-table.rows>
            @foreach($this->users as $user)
                <x-table.row :key="$user->id">
                    <x-table.cell>
                        {{ $user->name }}
                    </x-table.cell>
                    <x-table.cell>
                        {{ $user->email }}
                    </x-table.cell>
                    <x-table.cell>
                        @foreach($user->roles as $role)
                            <flux:badge color="indigo" size="sm">{{ $role->name }}</flux:badge>
                        @endforeach
                    </x-table.cell>
                    <x-table.cell class="text-right">
                        @php $actions = $this->actions($user); @endphp
                        <flux:dropdown align="end">
                            <flux:button size="sm" variant="subtle" icon="ellipsis-horizontal"
                                         :disabled="!$actions->count()"></flux:button>
                            <flux:menu>
                                @foreach($actions as $action)
                                    @if ($action === 'separator')
                                        <flux:menu.separator/>
                                    @else
                                        <flux:menu.item icon="{{ $action->icon }}"
                                                        wire:click="{{ $action->method }}({{ $user }})">{{ $action->label }}</flux:menu.item>
                                    @endif
                                @endforeach
                            </flux:menu>
                        </flux:dropdown>
                    </x-table.cell>
                </x-table.row>
            @endforeach
        </x-table.rows>
    </x-table>

    <livewire:modals::users.create @saved="$refresh"/>

    @if ($this->user)
        <livewire:modals::users.edit :user="$this->user" @saved="$refresh"/>
        <flux:modal name="{{ Modal::CONFIRM }}" @close="$wire.user = null" class="max-w-sm">
            <div class="space-y-2">
                <flux:heading size="lg" level="2">{{ __('Delete user') }}</flux:heading>
                <flux:text>{{ __('Are you sure you want to delete the user :name?', ['name' => $this->user->name]) }}</flux:text>
            </div>
            <div class="flex justify-end mt-6 gap-2">
                <flux:button variant="danger" wire:click="delete" size="sm">{{ __('Delete') }}</flux:button>
            </div>
        </flux:modal>
    @endif

</div>
