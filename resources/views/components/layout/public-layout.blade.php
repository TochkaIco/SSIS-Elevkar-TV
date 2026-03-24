<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? "Elevkår" }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @stack('preloads')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-foreground">
<x-layout.public-nav />

<main {{ $attributes->merge(['class' => 'max-w-9xl mx-auto px-6 py-10']) }}>
    {{ $slot }}
</main>

<x-signature />
</body>
</html>
