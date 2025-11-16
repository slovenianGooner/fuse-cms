<?php

use App\Enum\Modal;
use App\Enum\Role;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';
    public array $roles = [];

    public function create(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],

            'roles' => [
                'array',
            ],
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
        ]);
        $user->assignRole($this->roles);
    }

    #[Computed]
    public function roles()
    {
        return Role::cases();
    }
};
?>

<flux:modal name="{{ Modal::CREATE_USER }}" class="max-w-lg w-full">
    <div class="flex flex-col space-y-6">
        <flux:heading size="lg">{{ __('Create User') }}</flux:heading>

        <flux:input label="{{ __('Name') }}" wire:model="name"/>

        <flux:input label="{{ __('Email') }}" wire:model="email"/>

        <flux:checkbox.group wire:model="roles" label="{{ __('Roles') }}">
            {{-- why is the computed property not working here? --}}
            @foreach(Role::cases() as $role)
                <flux:checkbox label="{{ $role->getLabel() }}" value="{{ $role->value }}"/>
            @endforeach
        </flux:checkbox.group>

        <div class="flex justify-end items-center gap-2">
            <flux:modal.close name="{{ Modal::CREATE_USER }}">
                <flux:button size="sm">{{ __('Cancel') }}</flux:button>
            </flux:modal.close>
            <flux:button size="sm" variant="primary" icon="plus" wire:click="create">{{ __('Create') }}</flux:button>
        </div>
    </div>
</flux:modal>
