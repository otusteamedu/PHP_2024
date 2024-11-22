<?php

namespace App\Application\UseCase\News\GetTitle;

use App\Domain\ValueObject\Url;

class GetTitleUseCaseResponse
{
    public function __construct(
        public readonly Url $url,
        public readonly string $title,
    ) {
    }
}
