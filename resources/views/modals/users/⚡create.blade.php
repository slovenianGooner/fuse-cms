<?php

use App\Enum\LivewireEvent;
use App\Enum\Modal;
use App\Enum\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public array $roles = [];

    public function onModalClose(): void
    {
        $this->reset();
    }

    public function create(): void
    {
        try {
            $this->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
                'roles' => ['array'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('password', 'password_confirmation');

            throw $e;
        }

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
        $user->assignRole($this->roles);

        $this->dispatch(LivewireEvent::SAVED);
        $this->modal(Modal::CREATE_USER)->close();
    }

    #[Computed]
    public function availableRoles(): array
    {
        return Role::cases();
    }
};
?>

<flux:modal name="{{ Modal::CREATE_USER }}" class="max-w-lg w-full" variant="flyout" @close="onModalClose">
    <div class="flex flex-col space-y-6">
        <flux:heading size="lg">{{ __('Create User') }}</flux:heading>

        <flux:input label="{{ __('Name') }}" wire:model="name"/>

        <flux:input label="{{ __('Email') }}" wire:model="email"/>

        <flux:input wire:model="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="new-password"
        />

        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirm Password')"
            type="password"
            required
            autocomplete="new-password"
        />

        <flux:checkbox.group wire:model="roles" label="{{ __('Roles') }}">
            @foreach($this->availableRoles as $role)
                <flux:checkbox label="{{ $role->getLabel() }}" value="{{ $role->value }}"/>
            @endforeach
        </flux:checkbox.group>

        <div class="flex justify-end items-center gap-2">
            <flux:modal.close name="{{ Modal::CREATE_USER }}">
                <flux:button size="sm">{{ __('Cancel') }}</flux:button>
            </flux:modal.close>
            <flux:button size="sm" variant="primary" wire:click="create">{{ __('Create') }}</flux:button>
        </div>
    </div>
</flux:modal>
