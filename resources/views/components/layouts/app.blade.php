<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite('resources/css/app.css')
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>        
        <link href="https://fonts.googleapis.com/css2?family=Alkatra:wght@400..700&family=Mallanna&family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Sacramento&display=swap" rel="stylesheet">
        <link rel="manifest" href="/manifest.json" />
        <title>{{ $title ?? 'Coral Food کورال فود' }}</title>
    </head>
    <body>        
        {{ $slot }}
    </body>
</html>
