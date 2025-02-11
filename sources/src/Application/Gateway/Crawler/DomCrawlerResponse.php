<?php

declare(strict_types=1);

namespace App\Application\Gateway\Crawler;

readonly class DomCrawlerResponse
{
    public function __construct(
        private string $title
    )
    {
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}