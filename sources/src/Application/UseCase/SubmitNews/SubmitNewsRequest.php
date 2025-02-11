<?php

declare(strict_types=1);

namespace App\Application\UseCase\SubmitNews;

readonly class SubmitNewsRequest
{
    public function __construct(
        private string $url,
    )
    {
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}