<?php

namespace App\Application\UseCase\News\CreateHtml;

class CreateHtmlUseCaseResponse
{
    public function __construct(
        public readonly string $href,
    ) {
    }
}
