<?php

declare(strict_types=1);

namespace App\Application\UseCase\ApiRequest\DTO;

class StatusRequest
{
    public function __construct(public readonly int $id)
    {
    }
}
