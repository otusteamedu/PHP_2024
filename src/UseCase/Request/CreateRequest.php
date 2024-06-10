<?php

declare(strict_types=1);

namespace App\UseCase\Request;

readonly class CreateRequest
{
    public function __construct(public array $data)
    {
    }
}
