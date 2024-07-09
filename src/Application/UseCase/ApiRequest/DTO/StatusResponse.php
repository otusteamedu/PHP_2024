<?php

declare(strict_types=1);

namespace App\Application\UseCase\ApiRequest\DTO;

class StatusResponse
{
    public function __construct(public readonly string $status)
    {
    }
}
