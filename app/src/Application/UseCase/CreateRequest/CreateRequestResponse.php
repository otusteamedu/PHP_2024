<?php

namespace App\Application\UseCase\CreateRequest;

class CreateRequestResponse
{
    public function __construct(
        public int $id
    ) {
    }
}
