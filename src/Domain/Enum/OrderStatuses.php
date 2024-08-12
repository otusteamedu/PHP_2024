<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum OrderStatuses: string
{
    case New = 'new';
    case Cooking = 'cooking';
    case Cooked = 'cooked';
    case ForPickup = 'forPickup';
    case Completed = 'completed';
}
