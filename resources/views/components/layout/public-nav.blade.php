<nav class="border-b border-border px-6">
    <div class="max-w-9xl mx-auto h-24 flex items-center justify-between">
        <a href="{{ route('events.index') }}" class="flex items-center justify-between gap-x-3">
            @push('preloads')
                <link rel="preload" as="image" href="{{ asset('images/logo.png') }}">
            @endpush
            <img src="{{ asset('images/logo.png') }}" alt="{{ __('Logo') }}" width="75" class="rounded-2xl">
            <h3 class="font-bold text-4xl">SSIS Elevkår</h3>
        </a>

        <div class="flex gap-x-3 items-center">
            <p class="text-xl">{{ __('See more at') }} {{ config('app.url') }}</p>
        </div>
    </div>
</nav>
