<?php

namespace KRudenko\Otus\Entity;

use KRudenko\Otus\Database\ActiveRecord;

class User extends ActiveRecord
{
    protected static string $tableName = 'user';

    protected ?int $id = null;
    protected string $name = '';
    protected string $email = '';
}
