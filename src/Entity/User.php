<?php

namespace KRudenko\Otus\Entity;

use KRudenko\Otus\Database\ActiveRecord;

class User extends ActiveRecord
{
    protected static string $tableName = 'user';

    public ?int $id = null;
    public string $name = '';
    public string $email = '';
}
