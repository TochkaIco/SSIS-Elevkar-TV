<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Event;
use Illuminate\Support\Facades\DB;

class UpdateEvent
{
    public function handle(array $attributes, Event $event): void
    {
        $data = collect($attributes)->only([
            'title', 'description', 'links', 'display_starts_at', 'display_ends_at',
        ])->toArray();

        if ($attributes['image'] ?? false) {
            $data['image_path'] = $attributes['image']->store('events', 'public');
        }

        DB::transaction(function () use ($event, $data, $attributes) {
            $event->update($data);

            $event->steps()->delete();
            $event->steps()->createMany($attributes['steps'] ?? []);
        });
    }
}
