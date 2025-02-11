<?php

declare(strict_types=1);

namespace App\Application\Gateway;

readonly class DomCrawlerResponse
{
    public function __construct(
        public string $title
    )
    {
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}