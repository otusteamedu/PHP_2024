<?php

declare(strict_types=1);

namespace App\Application\UseCase\SubmitNews;

readonly class SubmitNewsResponse
{
    public function __construct(
        private int $id,
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
}