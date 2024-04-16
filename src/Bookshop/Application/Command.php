<?php

declare(strict_types=1);

namespace AlexanderGladkov\Bookshop\Application;

enum Command: string
{
    case CreateIndex = 'create-index';
    case Search = 'search';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
