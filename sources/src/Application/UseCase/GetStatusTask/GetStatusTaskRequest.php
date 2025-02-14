<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetStatusTask;

class GetStatusTaskRequest
{
    public function __construct(
        public string $id,
    )
    {
    }
}