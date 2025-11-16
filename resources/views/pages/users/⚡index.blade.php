<?php

use App\DTO\Admin\Table\Action;
use App\Enum\Modal;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Flux\Flux;

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

        return $actions;
    }

    public function edit(User $user): void
    {
        if (auth()->user()->cannot('update', $user)) {
            abort(403);
        }

        $this->user = $user;
        Flux::modal(Modal::EDIT_USER)->show();
    }

    public function impersonate(User $user): void
    {
        if (auth()->user()->cannot('impersonate', $user)) {
            abort(403);
        }

        $this->redirect(route('admin.impersonate', $user->id));
    }
};
?>

<div class="p-6 max-w-screen-lg">

    <div class="relative mb-2 w-full flex justify-between items-end">
        <flux:heading size="xl" level="1">{{ __('Users') }}</flux:heading>
        @can('create', User::class)
            <flux:modal.trigger name="{{ Modal::CREATE_USER }}">
                <flux:button variant="primary" size="sm" icon="plus">{{ __('Create') }}</flux:button>
            </flux:modal.trigger>
        @endcan
    </div>

    <x-table :paginate="$this->users">
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
                            @if ($actions->count())
                                <flux:menu>
                                    @foreach($actions as $action)
                                        <flux:menu.item icon="{{ $action->icon }}"
                                                        wire:click="{{ $action->method }}({{ $user }})">{{ $action->label }}</flux:menu.item>
                                    @endforeach
                                </flux:menu>
                            @endif
                        </flux:dropdown>
                    </x-table.cell>
                </x-table.row>
            @endforeach
        </x-table.rows>
    </x-table>

    <livewire:modals::users.create/>

    @if ($this->user)
        <livewire:modals::users.edit :user="$this->user"/>
    @endif

</div>
