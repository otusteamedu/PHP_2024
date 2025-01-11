<?php

namespace App\Infrastructure\Factory;

use App\Domain\Entity\Account;
use App\Domain\Factory\AccountFactoryInterface;
use App\Domain\ValueObject\HolderEmail;
use App\Domain\ValueObject\HolderName;

class AccountFactory implements AccountFactoryInterface
{

    public function create(string $holderName, string $holderEmail): Account
    {
        return new Account(
            new HolderName($holderName),
            new HolderEmail($holderEmail)
        );
    }
}