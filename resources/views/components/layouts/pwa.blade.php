<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('images/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    @vite('resources/css/app.css')
    @livewireStyles

    <!-- Google Fonts -->
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alkatra:wght@400..700&family=Mallanna&family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Sacramento&display=swap" rel="stylesheet"> --}}

    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <title>{{ $title ?? 'Coral Food کورال فود' }}</title>
</head>
<body class="m-0 p-0 bg-coral-body">
    <!-- Main Slot -->
    <main class="max-w-screen mx-auto my-0 p-1">
        {{ $slot }}
    </main>

    <!-- Scripts -->
    @vite('resources/js/app.js')
    @stack('scripts')
    @livewireScripts
</body>
</html>
