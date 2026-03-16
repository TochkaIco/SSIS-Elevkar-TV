@props(['event' => new \App\Models\Event()])

<x-modal name="{{ $event->exists ? 'edit-event' : 'create-event' }}" title="{{ $event->exists ? __('Edit Event') : __('Create Event') }}">
    <form
        x-data="{
                    newLink: '',
                    links: @js(old('links', $event->links ?? [])),
                    newStep: '',
                    steps: @js(old('steps', $event->steps->map->only(['id', 'description', 'completed']))),
                    hasImage: false,
                }"
        action="{{ $event->exists ? route('admin.event.update', $event) : route('admin.event.store') }}"
        method="post"
        x-bind:enctype="hasImage ? 'multipart/form-data' : false"
    >
        @csrf
        @if($event->exists)
            @method('PATCH')
        @endif

        <div class="space-y-6">
            <x-form.field
                label="{{ __('Title') }}"
                name="title"
                data-test="title-field"
                placeholder="{{ __('Enter a title for your event') }}"
                autofocus
                required
                :value="$event->title"
            />

            <x-form.field
                label="{{ __('Description') }}"
                name="description"
                type="textarea"
                data-test="description-field"
                placeholder="{{ __('Describe your event...') }}"
                required
                :value="$event->description"
            />

            <div class="flex items-center justify-between">
                <span>
                    <label for="display_starts_at" class="label">{{ __('Display starts at') }} </label>
                    <input
                        type="datetime-local"
                        name="display_starts_at"
                        data-test="display_starts_at"
                        value="{{ old('display_starts_at', $event->display_starts_at?->format('Y-m-d\TH:i')) }}"
                    >
                    <x-form.error name="display_starts_at" />
                </span>
                <span>
                    <label for="display_ends_at" class="label">{{ __('Display ends at') }} </label>
                    <input
                        type="datetime-local"
                        name="display_ends_at"
                        data-test="display_ends_at"
                        value="{{ old('display_starts_at', $event->display_ends_at?->format('Y-m-d\TH:i')) }}"
                    >
                    <x-form.error name="display_ends_at" />
                </span>
            </div>

            <div class="space-y-2">
                <label for="image" class="label">{{ __('Featured Image') }}</label>

                @if($event->image_path)
                    <div class="space-y-2">
                        <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ __('Image') }}"
                             class="w-full h-auto max-h-60 object-cover mb-2 rounded-lg">
                        <button class="btn btn-outlined h-10 w-full" form="delete-image-form">{{ __('Remove Image') }}</button>
                    </div>
                @endif

                <input
                    type="file"
                    name="image"
                    id="image"
                    data-test="image-field"
                    accept="image/*"
                    @change="hasImage = $event.target.files.length > 0"
                >
                <x-form.error name="image" />
            </div>

            <div>
                <fieldset class="space-y-3">
                    <legend class="label">{{ __('Steps') }}</legend>

                    <div class="flex gap-x-2 items-center">
                        <input
                            x-model="newStep"
                            type="text"
                            id="new-step"
                            data-test="new-step-field"
                            placeholder="{{ __('What are the steps?') }}"
                            class="input flex-1"
                        >

                        <button
                            type="button"
                            @click="
                                steps.push({description: newStep.trim(), completed: false});
                                newStep='';
                            "
                            :disabled="newStep.trim().length === 0"
                            class="form-muted-icon"
                            data-test="add-step-button"
                            aria-label="Add step button"
                        >
                            <x-icons.close class="rotate-45" />
                        </button>
                    </div>

                    <template x-for="(step, index) in steps" :key="step.id || index">
                        <div class="flex gap-x-2 items-center">
                            <input :name="`steps[${index}][description]`" x-model="step.description" class="input" readonly>
                            <input type="hidden" :name="`steps[${index}][completed]`" x-model="step.completed ? '1' : '0'" class="input" readonly>

                            <button
                                type="button"
                                @click="steps.splice(index, 1)"
                                class="form-muted-icon"
                                data-test="remove-step-button"
                                aria-label="Remove step button"
                            >
                                <x-icons.close />
                            </button>
                        </div>
                    </template>
                </fieldset>
            </div>

            <div>
                <fieldset class="space-y-3">
                    <legend class="label">{{ __('Links') }}</legend>

                    <div class="flex gap-x-2 items-center">
                        <input
                            x-model="newLink"
                            type="url"
                            id="new-link"
                            data-test="new-link-field"
                            placeholder="https://example.com"
                            autocomplete="url"
                            class="input flex-1"
                            spellcheck="false"
                        >

                        <button
                            type="button"
                            @click="links.push(newLink.trim()); newLink='';"
                            :disabled="newLink.trim().length === 0"
                            class="form-muted-icon"
                            data-test="add-link-button"
                            aria-label="Add link button"
                        >
                            <x-icons.close class="rotate-45" />
                        </button>
                    </div>

                    <template x-for="(link, index) in links" :key="link">
                        <div class="flex gap-x-2 items-center">
                            <input
                                type="text"
                                name="links[]"
                                x-model="link"
                                class="input"
                                readonly
                            >

                            <button
                                type="button"
                                @click="links.splice(index, 1)"
                                class="form-muted-icon"
                                data-test="remove-link-button"
                                aria-label="Remove link button"
                            >
                                <x-icons.close />
                            </button>
                        </div>
                    </template>
                </fieldset>
            </div>

            <div class="flex justify-end gap-x-5">
                <button type="button" @click="$dispatch('close-modal')">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-primary" data-test="submit-button">{{ $event->exists ? __('Save') : __('Create') }}</button>
            </div>
        </div>
    </form>

    @if($event->image_path)
        <form action="{{ route('admin.event.image.destroy', $event) }}" id="delete-image-form" method="post">
            @csrf
            @method('DELETE')
        </form>
    @endif
</x-modal>
