<?php

use App\Enum\Modal;
use App\Models\User;
use Livewire\Component;

new class extends Component {
    public User $user;
};
?>

<flux:modal name="{{ Modal::EDIT_USER }}">
    @dump($this->user)
    <div class="flex justify-end items-center gap-2">
        <flux:modal.close name="{{ Modal::EDIT_USER }}">
            <flux:button size="sm">{{ __('Cancel') }}</flux:button>
        </flux:modal.close>
        <flux:button size="sm" variant="primary">{{ __('Save changes') }}</flux:button>
    </div>
</flux:modal>

