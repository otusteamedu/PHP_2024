<?php

namespace App\Application\UseCase\News\GetNewsListByIdArray;

class GetNewsListByIdUseCaseResponse
{
    public function __construct(
        public readonly string $urlValue,
        public readonly string $title
    ) {
    }
}
