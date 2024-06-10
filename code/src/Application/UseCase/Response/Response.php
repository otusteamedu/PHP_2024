<?php

namespace App\Application\UseCase\Response;

readonly class Response
{
    public function __construct(
        public int $status,
        public string $recipe,
        public int $id
    ){}
}