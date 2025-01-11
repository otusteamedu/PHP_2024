<?php

namespace App\Application\UseCase\CreateStatement;

class CreateStatementResponse
{
    public function __construct(
        public int $id
    )
    {
    }

}