@php use App\DTO\Admin\SidebarMenuGroup; @endphp
@props(['items'])

@foreach($items as $item)
    @if ($item instanceof SidebarMenuGroup)
        <flux:sidebar.group icon="{{ $item->icon }}" expandable :expanded="$item->expanded"
                            heading="{{ $item->heading }}"
                            class="grid">
            <x-layouts::app.sidebar-group :items="$item->items"/>
        </flux:sidebar.group>
    @else
        <flux:sidebar.item icon="{{ $item->icon }}" href="{{ $item->url }}" :current="$item->active" wire:navigate>
            {{ $item->label }}
        </flux:sidebar.item>
    @endif
@endforeach
