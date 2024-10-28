<?php

namespace App\Application\UseCase\News\CreateHtml;

class CreateHtmlUseCaseRequest
{
    public function __construct(
        public readonly string $urlValue,
        public readonly string $title
    ) {
    }
}
