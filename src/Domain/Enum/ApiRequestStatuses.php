<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum ApiRequestStatuses: string
{
    case IN_PROGRESS = 'in progress';
    case PROCESSED = 'processed';
    case FAILED = 'failed';
    case CANCELLED = 'cancelled';
}
