<x-layout.public-layout title="{{ __('TV Page') }}">
    <div>
        @if($events && $events->count()===1)
            <header class="py-8 md:py-12 flex flex-col items-center text-center mx-auto">
                <h1 class="text-4xl font-bold">{{ __("Current SSIS Events") }}</h1>
            </header>
        @else
            <header class="py-8 md:py-12">
                <h1 class="text-4xl font-bold">{{ __("Current SSIS Events") }}</h1>
            </header>
        @endif
        <div class="text-muted-foreground">
            @if($events && $events->count()===1)
                <x-card href="{{ route('event.show', $events[0]) }}" class="max-w-5xl mx-auto items-center">
                    @if($events[0]->image_path)
                        <div class="mb-4 -mx-4 -mt-4 rounded-t-lg overflow-hidden">
                            @push('preloads')
                                <link rel="preload" as="image" href="{{ asset('storage/' . $events[0]->image_path) }}">
                            @endpush
                            <img
                                src="{{ asset('storage/' . $events[0]->image_path) }}"
                                alt="{{ __('Image') }}"
                                class="w-full h-auto max-h-80 object-cover mb-2"
                            >
                        </div>
                    @endif

                    <h3 class="text-foreground text-xl">{{ $events[0]->title }}</h3>
                    <p class="mt-2 line-clamp-2">{!! $events[0]->formattedDescription !!}</p>
                    <x-divider />
                    <div class="flex gap-x-3 items-center text-muted-foreground text-sm">
                        <span>{{ __('Created') }} {{ $events[0]->created_at->diffForHumans() }}</span>
                    </div>
                </x-card>
            @else
                <div class="grid md:grid-cols-2 gap-6">
                    @forelse($events as $event)
                        <x-card href="{{ route('event.show', $event) }}">
                            @if($event->image_path)
                                <div class="mb-4 -mx-4 -mt-4 rounded-t-lg overflow-hidden">
                                    @push('preloads')
                                        @foreach($events as $event)
                                            @if($event->image_path)
                                                <link rel="preload" as="image" href="{{ asset('storage/' . $event->image_path) }}">
                                            @endif
                                        @endforeach
                                    @endpush
                                    <img
                                        src="{{ asset('storage/' . $event->image_path) }}"
                                        alt="{{ __('Image') }}"
                                        class="w-full h-auto max-h-60 object-cover mb-2"
                                    >
                                </div>
                            @endif

                            <h3 class="text-foreground text-xl">{{ $event->title }}</h3>
                            <p class="mt-2 line-clamp-2">{!! $event->formattedDescription !!}</p>
                            <x-divider />
                            <div class="flex gap-x-3 items-center text-muted-foreground text-sm">
                                <span>{{ __('Created') }} {{ $event->created_at->diffForHumans() }}</span>
                            </div>
                        </x-card>
                    @empty
                        <x-card>
                            <h2 class="text-xl">{{ __('No scheduled events at this time') }}</h2>
                        </x-card>
                    @endforelse
                </div>
            @endif
        </div>
    </div>
</x-layout.public-layout>
