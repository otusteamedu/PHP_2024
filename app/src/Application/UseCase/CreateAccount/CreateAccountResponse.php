<?php

namespace App\Application\UseCase\CreateAccount;

class CreateAccountResponse
{
    public function __construct(
        public int $id
    )
    {
    }

}