<?php

namespace App\Models;

use App\EventStatus;
use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Event extends Model
{
    /** @use HasFactory<EventFactory> */
    use HasFactory;

    protected $casts = [
        'links' => AsArrayObject::class,
        'display_starts_at' => 'datetime',
        'display_ends_at' => 'datetime',
    ];

    public static function statusCounts(): Collection
    {
        return collect([
            'awaiting' => Event::where('display_starts_at', '>', now())->count(),
            'in_effect' => Event::where('display_starts_at', '<=', now())
                ->where('display_ends_at', '>=', now())->count(),
            'completed' => Event::where('display_ends_at', '<', now())->count(),
            'all' => Event::count(),
        ]);
    }

    public function steps(): HasMany
    {
        return $this->hasMany(EventStep::class);
    }

    protected function status(): Attribute
    {
        return Attribute::get(function () {
            $now = now();

            if ($this->display_starts_at > $now) {
                return EventStatus::AWAITING;
            }

            if ($this->display_ends_at < $now) {
                return EventStatus::COMPLETED;
            }

            return EventStatus::IN_EFFECT;
        });
    }

    protected function formattedDescription(): Attribute
    {
        return Attribute::get(fn (mixed $value, array $attributes) => str($attributes['description'])->markdown());
    }
}
