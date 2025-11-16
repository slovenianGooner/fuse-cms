<?php

use App\Enum\LivewireEvent;
use App\Enum\Modal;
use App\Enum\Role;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    public User $user;

    public string $name = '';
    public string $email = '';
    public array $roles = [];

    public function mount(): void
    {
        $this->fill([
            'name' => $this->user->name,
            'email' => $this->user->email,
            'roles' => $this->user->roles->pluck('name')->toArray(),
        ]);
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user->id)],
            'roles' => ['array'],
        ]);

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);
        $this->user->syncRoles($this->roles);

        $this->dispatch(LivewireEvent::SAVED);
        $this->modal(Modal::EDIT_USER)->close();
    }

    #[Computed]
    public function availableRoles(): array
    {
        return Role::cases();
    }
};
?>

<flux:modal name="{{ Modal::EDIT_USER }}" class="max-w-lg w-full" variant="flyout">
    <div class="flex flex-col space-y-6">
        <flux:heading size="lg">{{ __('Edit User') }}</flux:heading>

        <flux:input label="{{ __('Name') }}" wire:model="name"/>

        <flux:input label="{{ __('Email') }}" wire:model="email"/>

        <flux:checkbox.group wire:model="roles" label="{{ __('Roles') }}">
            @foreach($this->availableRoles as $role)
                <flux:checkbox label="{{ $role->getLabel() }}" value="{{ $role->value }}"/>
            @endforeach
        </flux:checkbox.group>

        <div class="flex justify-end items-center gap-2">
            <flux:modal.close name="{{ Modal::EDIT_USER }}">
                <flux:button size="sm">{{ __('Cancel') }}</flux:button>
            </flux:modal.close>
            <flux:button size="sm" variant="primary" wire:click="save">{{ __('Save changes') }}</flux:button>
        </div>
    </div>
</flux:modal>

