<?php

namespace App\Application\UseCase\Request;

readonly class Request
{
    public function __construct(
        public string $type,
        public string $recipe,
        public ?string $ingredient
    ){}

}