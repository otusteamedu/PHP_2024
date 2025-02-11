<?php

declare(strict_types=1);

namespace App\Application\Gateway;

use App\Domain\ValueObject\Url;

readonly class DomCrawlerRequest
{
    public function __construct(
        public Url $url
    )
    {
    }

    public function getUrl(): string
    {
        return $this->url->getUrl();
    }
}