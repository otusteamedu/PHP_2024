<?php

declare(strict_types=1);

namespace App\Application\UseCase\SubmitTask;

class SubmitTaskResponse
{
    public function __construct(
        public string $id,
    )
    {
    }
}