<?php

declare(strict_types=1);

namespace App\Application\UseCase\SubmitTask;

class SubmitTaskRequest
{
    public function __construct(
        public string $title,
    )
    {
    }
}