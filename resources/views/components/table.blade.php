@props(['paginate' => null])
<div class="w-full rounded-md border border-zinc-800/10 dark:border-white/20 overflow-x-auto max-w-full">
    <table class="min-w-full table-fixed divide-y divide-zinc-800/10 dark:divide-white/20">
        {{ $slot }}
    </table>
</div>
@if ($paginate)
    <div class="mt-2">
        {!! $paginate->onEachSide(1)->links() !!}
    </div>
@endif
