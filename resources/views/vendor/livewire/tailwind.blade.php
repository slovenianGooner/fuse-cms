@php
    if (! isset($scrollTo)) {
        $scrollTo = 'body';
    }

    $scrollIntoViewJsSnippet = ($scrollTo !== false)
        ? <<<JS
           (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
        JS
        : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
            <!-- mobile pagination -->
            <div class="flex justify-between flex-1 sm:hidden">
                <span>
                    @if ($paginator->onFirstPage())
                        <flux:button size="sm" :disabled="true">
                            {!! __('pagination.previous') !!}
                        </flux:button>
                    @else
                        <flux:button size="sm" wire:click="previousPage('{{ $paginator->getPageName() }}')"
                                     x-on:click="{{ $scrollIntoViewJsSnippet }}">
                            {!! __('pagination.previous') !!}
                        </flux:button>
                    @endif
                </span>

                <span>
                    @if ($paginator->hasMorePages())
                        <flux:button size="sm" wire:click="nextPage('{{ $paginator->getPageName() }}')"
                                     x-on:click="{{ $scrollIntoViewJsSnippet }}">
                            {!! __('pagination.next') !!}
                        </flux:button>
                    @else
                        <flux:button size="sm" :disabled="true">
                            {!! __('pagination.next') !!}
                        </flux:button>
                    @endif
                </span>
            </div>

            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-zinc-500 leading-5 dark:text-zinc-400">
                        <span>{!! __('Showing') !!}</span>
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        <span>{!! __('to') !!}</span>
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                        <span>{!! __('of') !!}</span>
                        <span class="font-medium">{{ $paginator->total() }}</span>
                        <span>{!! __('results') !!}</span>
                    </p>
                </div>

                <div>
                    <span
                        class="relative z-0 inline-flex rtl:flex-row-reverse rounded-md border border-zinc-800/10 dark:border-white/20 px-0.5 py-0.5">
                        <span>
                            {{-- Previous Page Link --}}
                            @if ($paginator->onFirstPage())
                                <flux:button variant="subtle" size="sm" icon="chevron-left" :disabled="true"/>
                            @else
                                <flux:button variant="subtle" size="sm" icon="chevron-left"
                                             wire:click="previousPage('{{ $paginator->getPageName() }}')"
                                             x-on:click="{{ $scrollIntoViewJsSnippet }}"/>
                            @endif
                        </span>

                        {{-- Pagination Elements --}}
                        @foreach ($elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <flux:button variant="subtle" size="sm" icon="ellipsis-horizontal" :disabled="true"/>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    <span wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}">
                                        @if ($page == $paginator->currentPage())
                                            <flux:button variant="subtle" size="sm" :disabled="true">
                                                {{ $page }}
                                            </flux:button>
                                        @else
                                            <flux:button variant="subtle" size="sm"
                                                         wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                                         x-on:click="{{ $scrollIntoViewJsSnippet }}">
                                                {{ $page }}
                                            </flux:button>
                                        @endif
                                    </span>
                                @endforeach
                            @endif
                        @endforeach

                        <span>
                            {{-- Next Page Link --}}
                            @if ($paginator->hasMorePages())
                                <flux:button variant="subtle" size="sm" icon="chevron-right"
                                             wire:click="nextPage('{{ $paginator->getPageName() }}')"
                                             x-on:click="{{ $scrollIntoViewJsSnippet }}"/>
                            @else
                                <flux:button variant="subtle" size="sm" icon="chevron-right" :disabled="true"/>
                            @endif
                        </span>
                    </span>
                </div>
            </div>
        </nav>
    @endif
</div>
