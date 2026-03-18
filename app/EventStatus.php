<?php

declare(strict_types=1);

namespace App;

enum EventStatus: string
{
    case AWAITING = 'awaiting';
    case IN_EFFECT = 'in_effect';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::AWAITING => 'Awaiting',
            self::IN_EFFECT => 'In Effect',
            self::COMPLETED => 'Completed',
        };
    }
}
