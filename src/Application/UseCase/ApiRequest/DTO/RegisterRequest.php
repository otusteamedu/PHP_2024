<?php

declare(strict_types=1);

namespace App\Application\UseCase\ApiRequest\DTO;

class RegisterRequest
{
    public function __construct(public readonly string $body, public readonly ?int $id = null)
    {
    }
}
