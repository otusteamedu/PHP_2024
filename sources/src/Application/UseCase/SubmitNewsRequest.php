<?php

declare(strict_types=1);

namespace App\Application\UseCase;

readonly class SubmitNewsRequest
{
    public function __construct(
        public string $url,
    )
    {
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}