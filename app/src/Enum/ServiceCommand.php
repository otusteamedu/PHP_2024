<?php

declare(strict_types=1);

namespace App\Enum;

enum ServiceCommand: string
{
    case ServerStart   = 'server:start';
    case ClientStart   = 'client:start';
    case ChatStop      = 'chat:stop';
}
