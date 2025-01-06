<?php

namespace Amikha1lov\DataMapper\Mappers;

use Amikha1lov\DataMapper\Entities\User;

class UserMapper extends DataMapper
{
    protected function getTableName(): string
    {
        return 'user';
    }

    protected function getColumns(): array
    {
        return [
            'id',
            'name',
            'age'
        ];
    }

    protected function instantiate(array $data): ?User
    {
        return new User(
            $data['id'],
            $data['name'],
            $data['age']
        );
    }
}
