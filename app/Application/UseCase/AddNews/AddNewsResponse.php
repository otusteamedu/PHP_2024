<?php

namespace App\Application\UseCase\AddNews;

class AddNewsResponse
{
    public function __construct(
        public int $id
    ) {
    }
}
