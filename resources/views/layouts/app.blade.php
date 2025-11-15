<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('layouts.partials.head')
</head>
<body class="h-screen bg-white dark:bg-zinc-800">
<x-layouts::app.sidebar/>
<x-layouts::app.header/>

<flux:main class="flex-1 overflow-y-auto p-0!">
    {{ $slot }}
</flux:main>

@fluxScripts
</body>
</html>
