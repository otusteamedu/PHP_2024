<?php

namespace App\Application\UseCase\News\CreateNews;

use App\Domain\ValueObject\Url;

class CreateNewsUseCaseRequest
{
    public function __construct(
        public readonly string $tile,
        public readonly Url $url
    ) {
    }
}
