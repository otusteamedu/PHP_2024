<?php

declare(strict_types=1);

namespace Valen\App\Application\News\UseCase\AddNews;

readonly class AddNewsResponse
{
    public function __construct(
        public int $id
    ) {
    }
}
