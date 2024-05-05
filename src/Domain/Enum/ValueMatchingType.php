<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum ValueMatchingType
{
    case EQUALS;
    case GREATER_THAN;
    case LESS_THAN;
    case ENTRY;
}
