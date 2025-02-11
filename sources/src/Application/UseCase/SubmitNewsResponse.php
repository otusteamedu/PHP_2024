<?php

declare(strict_types=1);

namespace App\Application\UseCase;

readonly class SubmitNewsResponse
{
    public function __construct(
        public int $id,
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
}