<?php

declare(strict_types=1);

namespace AlexanderGladkov\Analytics\Application;

enum Command: string
{
    case Add = 'add';
    case Get = 'get';
    case DeleteAll = 'delete-all';
    case FillTestData = 'fill-test-data';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
