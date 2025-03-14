<?php

namespace App\Application\UseCase\AddNews;

class AddNewsRequest
{
    public function __construct(
        public string $title,
        public string $author,
        public string $category,
        public string $text,
    ) {
    }
}
