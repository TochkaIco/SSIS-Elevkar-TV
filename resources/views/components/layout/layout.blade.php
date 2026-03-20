<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? "Elevkår" }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-foreground">
    <x-layout.nav />

    <main {{ $attributes->merge(['class' => 'max-w-7xl mx-auto px-6 py-10']) }}>
    {{ $slot }}
    </main>

    @session('success')
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition.opacity.duration.300ms
        class="bg-primary px-4 py-2 absolute bottom-4 right-4 rounded-l-lg rounded-tr-lg"
    >{{ $value }}</div>
    @endsession

    <x-signature/>
</body>
</html>
