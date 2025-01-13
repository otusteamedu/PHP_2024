<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\HolderEmail;
use App\Domain\ValueObject\HolderName;

class Account
{
    private ?int $id = null;

    public function __construct(
        private readonly HolderName $holderName,
        private readonly HolderEmail $holderEmail
    ) {
    }

    public function getHolderEmail(): HolderEmail
    {
        return $this->holderEmail;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHolderName(): HolderName
    {
        return $this->holderName;
    }
}
