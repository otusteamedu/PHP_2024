<?php

declare(strict_types=1);

namespace App\Application\UseCase\News\DTO;

use App\Domain\ValueObject\{NewsTitle, Url};

class ListNewsResponse
{
    public readonly string $url;
    public readonly string $title;

    public function __construct(
        public readonly int $id,
        public readonly string $date,
        NewsTitle $title,
        Url $url,
    ) {
        $this->url = $url->getValue();
        $this->title = $title->getValue();
    }
}
