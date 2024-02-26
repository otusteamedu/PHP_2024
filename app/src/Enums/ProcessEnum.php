<?php

declare(strict_types=1);

namespace App\src\Enums;

use App\src\Socket\ClientProcess;
use App\src\Socket\ServerProcess;

enum ProcessEnum: string
{
    case SERVER = 'server';
    case CLIENT = 'client';

    public function resolveProcessClass(): string
    {
        return match ($this) {
            self::CLIENT => ClientProcess::class,
            self::SERVER => ServerProcess::class,
        };
    }
}
