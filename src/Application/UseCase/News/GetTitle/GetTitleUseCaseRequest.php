<?php

namespace App\Application\UseCase\News\GetTitle;

use App\Domain\ValueObject\Url;

class GetTitleUseCaseRequest
{
    public function __construct(
        public readonly Url $url,
    ) {
    }
}
