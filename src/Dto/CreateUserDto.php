<?php

declare(strict_types=1);

namespace App\Dto;

readonly class CreateUserDto
{
    public function __construct(public string $name, public string $email)
    {
    }
}
