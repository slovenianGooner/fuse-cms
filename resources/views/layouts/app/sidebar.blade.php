@php use App\Services\Admin\MenuService; @endphp
<flux:sidebar sticky collapsible
              class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
    <flux:sidebar.header>
        <flux:sidebar.brand href="{{ route('admin.dashboard') }}" :name="config('app.name')"
                            class="[&>div]:text-sm">
            <x-slot:logo>
                <x-app-logo-icon class="text-zinc-900 dark:text-white size-6"/>
            </x-slot:logo>
        </flux:sidebar.brand>
        <flux:sidebar.collapse/>
    </flux:sidebar.header>

    <div>
        <flux:sidebar.nav variant="outline">
            <x-layouts::app.sidebar-group :items="MenuService::getMenu()"/>
        </flux:sidebar.nav>
    </div>
</flux:sidebar>
