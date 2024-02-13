<?php

declare(strict_types=1);

namespace App\Models;

use IKolyas\PersonNameFormat\PersonName;

class Customer
{
    private PersonName $nameFormat;

    public function __construct(readonly string $surname, readonly string $name, readonly string $patronymic)
    {
        $this->nameFormat = new PersonName($surname, $this->name, $this->patronymic);
    }

    public function nameFormat(): PersonName
    {
        return $this->nameFormat;
    }
}
