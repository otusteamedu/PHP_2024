<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetStatusTask;

class GetStatusTaskResponse
{
    public function __construct(
        public string $status,
    )
    {
    }
}