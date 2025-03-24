<?php

namespace App\Application\UseCase\CreateFood;

class CreateFoodRequest
{
    public function __construct(public string $name)
    {
    }
}