<?php

declare(strict_types=1);

namespace AlexanderGladkov\Analytics\Application\Arg;

enum AddArg: string
{
    case Priority = 'priority';
    case Condition = 'condition';
    case Value = 'value';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
