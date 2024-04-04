<?php

declare(strict_types=1);

namespace Hukimato\App\Models\Users;

use Hukimato\App\Models\DataMapper\AbstractDataMapper;

class UserMapper extends AbstractDataMapper
{
    protected static function getTableName(): string
    {
        return 'users';
    }

    protected static function getModelName(): string
    {
        return User::class;
    }
}