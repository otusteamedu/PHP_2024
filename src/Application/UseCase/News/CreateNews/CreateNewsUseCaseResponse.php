<?php

namespace App\Application\UseCase\News\CreateNews;

class CreateNewsUseCaseResponse
{
    public function __construct(
        public readonly int $id,
    ) {
    }
}
