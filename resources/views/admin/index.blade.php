<x-layout title="{{ __('Admin') }}">
    <div>
        <header class="py-8 md:py-12">
            <h1 class="text-3xl font-bold">{{ __('Admin Panel') }}</h1>
            <p class="text-muted-foreground text-sm mt-2">{{ __("Share SSIS events and plans.") }}</p>
            <x-card
                x-data
                is="button"
                data-test="create-event-button"
                class="mt-3 cursor-pointer h-32 w-full text-left"
                @click="$dispatch('open-modal', 'create-event')"
            >
                <p>{{ __("What's on your mind?") }}</p>
            </x-card>
        </header>

        <div>
            <a
                href="{{ route('admin.events.index') }}"
                class="btn {{ request()->has('status') ? 'btn-outlined' : '' }}"
            >
                {{ __('All') }}
                <span class="text-xs pl-2">{{ $statusCounts->get('all') }}</span>
            </a>

            @foreach(App\EventStatus::cases() as $status)
                <a
                    href="{{ route('admin.events.index', ['status' => $status->value]) }}"
                    class="btn {{ request('status') === $status->value ? '' : 'btn-outlined' }}"
                >
                    {{ __($status->label()) }}
                    <span class="text-xs pl-2">{{ $statusCounts->get($status->value) }}</span>
                </a>
            @endforeach
        </div>

        <div class="mt-10 text-muted-foreground">
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
                        <div class="mt-2">
                            <x-event.status-label status="{{ $event->status->value }}">
                                {{ __($event->status->label()) }}
                            </x-event.status-label>
                        </div>
                        <div class="mt-2 flex gap-x-3 items-center text-muted-foreground text-sm">
                            <span>{{ __('Created') }} {{ $event->created_at->diffForHumans() }}</span>
                            @can('admin')
                                @if($event->created_at != $event->updated_at)
                                    <span>{{ __('Updated') }} {{ $event->updated_at->diffForHumans() }}</span>
                                @endif
                            @endcan
                        </div>
                    </x-card>
                @empty
                    <x-card>
                        <p>{{ __('No scheduled events at this time') }}</p>
                    </x-card>
                @endforelse
            </div>
        </div>

        <x-admin.event.modal />
    </div>
</x-layout>
