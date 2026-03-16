<x-layout title="{{ __('Events') }}">
    <div>
        <header class="py-8 md:py-12">
            <h1 class="text-3xl font-bold">{{ __("Current Elevkår's Events") }}</h1>
        </header>
        <div class="text-muted-foreground">
            <div class="grid md:grid-cols-2 gap-6">
                @forelse($events as $event)
                    <x-card href="{{ route('event.show', $event) }}">
                        @if($event->image_path)
                            <div class="mb-4 -mx-4 -mt-4 rounded-t-lg overflow-hidden">
                                <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ __('Image') }}" class="w-full h-auto max-h-60 object-cover mb-2">
                            </div>
                        @endif

                        <h3 class="text-foreground text-lg">{{ $event->title }}</h3>
                        <p class="mt-5 line-clamp-2">{!! $event->formattedDescription !!}</p>
                        <x-divider />
                        <div class="flex gap-x-3 items-center text-muted-foreground text-sm">
                            <span>{{ __('Created') }} {{ $event->created_at->diffForHumans() }}</span>
                        </div>
                    </x-card>
                @empty
                    <x-card>
                        <p>{{ __('No scheduled events at this time') }}</p>
                    </x-card>
                @endforelse
            </div>
        </div>
    </div>
</x-layout>
