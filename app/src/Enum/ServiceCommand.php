<?php

declare(strict_types=1);

namespace App\Enum;

enum ServiceCommand: string
{
    case ServerStart   = 'server:start';
    case ClientStart   = 'client:start';
    case ChatStop      = 'chat:stop';
    case EmailValidate = 'server:check email';

    case StoragePost   = 'storage:post';
    case StorageGet    = 'storage:get';
    case StorageClear  = 'storage:clear';
}
