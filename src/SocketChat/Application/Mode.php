<?php

declare(strict_types=1);

namespace AlexanderGladkov\SocketChat\Application;

enum Mode: string
{
    case Server = 'server';
    case Client = 'client';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
