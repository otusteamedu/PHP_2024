<?php

declare(strict_types=1);

namespace App\Controller\Enum;

enum ServiceCommand: string
{
    case ServerStart   = 'server:start';
    case ClientStart   = 'client:start';
    case ChatStop      = 'chat:stop';

    case EmailValidate = 'check:email';

    case StoragePost   = 'storage:post';
    case StorageGet    = 'storage:get';
    case StorageClear  = 'storage:clear';

    case ElasticPost   = 'es:post';
    case ElasticGet    = 'es:get';
    case ElasticClear  = 'es:clear';

    case ElasticCreate = 'es:create';
    case ElasticInfo   = 'es:info';
    case ElasticBulk   = 'es:bulk';
    case ElasticRemove = 'es:remove';
    case ElasticSearch = 'es:search';
}
