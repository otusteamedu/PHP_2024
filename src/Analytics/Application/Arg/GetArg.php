<?php

declare(strict_types=1);

namespace AlexanderGladkov\Analytics\Application\Arg;

enum GetArg: string
{
    case Condition = 'condition';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
