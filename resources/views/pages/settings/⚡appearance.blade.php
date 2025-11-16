<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<section class="w-full p-6">
    <x-layouts::settings.heading/>
    <x-layouts::settings :heading="__('Appearance')"
                         :subheading=" __('Update the appearance settings for your account')">
        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
            <flux:radio value="light" icon="sun">{{ __('Light') }}</flux:radio>
            <flux:radio value="dark" icon="moon">{{ __('Dark') }}</flux:radio>
            <flux:radio value="system" icon="computer-desktop">{{ __('System') }}</flux:radio>
        </flux:radio.group>
    </x-layouts::settings>
</section>
