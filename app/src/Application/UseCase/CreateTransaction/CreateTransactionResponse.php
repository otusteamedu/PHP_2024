<?php

namespace App\Application\UseCase\CreateTransaction;

class CreateTransactionResponse
{
    public function __construct(
        public int $id
    )
    {
    }

}