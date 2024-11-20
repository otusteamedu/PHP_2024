<?php

namespace App\Application\UseCase\AddNews\Response;

readonly class AddNewsResponse
{
    public function __construct(
        public int $id
    ) {}
}