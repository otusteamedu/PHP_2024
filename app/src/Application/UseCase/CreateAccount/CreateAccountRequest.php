<?php

namespace App\Application\UseCase\CreateAccount;

class CreateAccountRequest
{
    public function __construct(
        public readonly string $holderName,
        public readonly string $holderEmail,
    ) {
    }
}
