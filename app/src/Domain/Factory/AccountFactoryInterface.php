<?php

namespace App\Domain\Factory;

use App\Domain\Entity\Account;

interface AccountFactoryInterface
{
    public function create(string $holderName, string $holderEmail): Account;
}