<?php

declare(strict_types=1);

namespace Valen\App\Application\News\UseCase\AddNews;

readonly class AddNewsRequest
{
    public function __construct(
        public string $url
    ) {
    }
}
