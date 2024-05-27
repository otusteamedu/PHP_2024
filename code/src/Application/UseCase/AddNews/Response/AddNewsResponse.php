<?php

namespace App\Application\UseCase\AddNews\Response;

class AddNewsResponse
{
    public function __construct(
        public string $id
    ) {}
}