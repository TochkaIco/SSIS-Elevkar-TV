<x-layout title="Event Show">
    <div class="py-8 max-w-4xl mx-auto">
        <div class="flex justify-between items-center">
            <a href="{{ route('admin.events.index') }}" class="flex items-center gap-x-2 text-sm font-medium">
                <x-icons.arrow-back/>
                Back to Events
            </a>

            <div class="flex gap-x-3 items-center">
                <button
                    x-data
                    class="btn btn-outlined"
                    data-test="edit-event-button"
                    @click="$dispatch('open-modal', 'edit-event')"
                >
                    <x-icons.external/>
                    Edit Event
                </button>
                <form action="{{ route('admin.event.destroy', $event) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outlined text-red-500">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-6">
            @if($event->image_path)
                <div class="rounded-lg overflow-hidden">
                    <img src="{{ asset('storage/' . $event->image_path) }}" alt="Image" class="w-full h-auto max-h-100 object-cover mb-2">
                </div>
            @endif

            <h1 class="font-bold text-4xl">{{ $event->title }}</h1>

            <div class="mt-2 flex gap-x-3 items-center">
                <x-event.status-label :status="$event->status->label()">{{ $event->status->label() }}</x-event.status-label>

                <div class="flex gap-x-3 items-center text-muted-foreground text-sm">
                    <span>Created {{ $event->created_at->diffForHumans() }}</span>
                    @if($event->created_at != $event->updated_at)
                        <span>Updated {{ $event->updated_at->diffForHumans() }}</span>
                    @endif
                </div>
            </div>

            @if($event->description)
                <x-card class="mt-6" is="div">
                    <div class="text-foreground max-w-none cursor-pointer prose prose-invert">{!! $event->formattedDescription !!}</div>
                </x-card>
            @endif

            @if($event->steps->count())
                <div>
                    <h3 class="font-bold text-xl mt-6">Actionable Steps</h3>

                    <div class="mt-3 space-y-3">
                        @foreach($event->steps as $step)
                            <x-card>
                                <form action="{{ route('admin.step.update', $step) }}" method="post">
                                    @csrf
                                    @method('PATCH')

                                    <div class="flex items-center gap-x-3">
                                        <button type="submit" role="checkbox" class="size-5 flex items-center justify-center rounded-lg text-primary-foreground {{ $step->completed ? 'bg-primary' : 'border border-primary' }}">&check;</button>
                                        <span class="{{ $step->completed ? 'line-through text-muted-foreground' : '' }}">{{ $step->description }}</span>
                                    </div>
                                </form>
                            </x-card>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($event->links->count())
                <div>
                    <h3 class="font-bold text-xl mt-6">Links</h3>

                    <div class="mt-3 space-y-3">
                        @foreach($event->links as $link)
                            <x-card :href="$link" class="text-primary flex font-medium gap-x-3 items-center">
                                <x-icons.external/>
                                {{ $link }}
                            </x-card>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <x-admin.event.modal :event="$event" />
    </div>
</x-layout>
