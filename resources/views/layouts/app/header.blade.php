<flux:header class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
    <flux:navbar class="w-full">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left"/>

        <flux:spacer/>

        @if (is_impersonating())
            <div class="fixed top-0 left-1/2 -ml-24">
                <flux:button icon="hat-glasses" variant="danger" size="xs" :href="route('admin.impersonate.leave')"
                             class="mr-1.5 w-48! rounded-t-none!">
                    Stop impersonating
                </flux:button>
            </div>
        @endif

        <flux:spacer/>

        <div class="flex items-center gap-1.5">
            <x-theme-switcher/>

            <flux:dropdown position="top" alignt="start">
                <flux:profile
                    initials="{{ auth()->user()->initials() }}"
                    name="{{ auth()->user()->name }}"
                    class="[&>span]:hidden lg:[&>span]:inline"/>

                <flux:menu class="w-40">
                    <flux:menu.item icon="cog" href="{{ route('admin.profile.edit') }}">
                        Settings
                    </flux:menu.item>

                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <flux:menu.item type="submit" icon="arrow-right-start-on-rectangle">
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </div>
    </flux:navbar>
</flux:header>
