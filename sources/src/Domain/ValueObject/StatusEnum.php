<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

enum StatusEnum: string
{
    case PROGRESS = 'progress';
    case COMPLETED = 'completed';
}
