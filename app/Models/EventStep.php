<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventStep extends Model
{
    use HasFactory;

    protected $attributes = [
        'completed' => false,
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
