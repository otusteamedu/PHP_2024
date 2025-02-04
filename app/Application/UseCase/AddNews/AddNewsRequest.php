<?php

namespace App\Application\UseCase\AddNews;

class AddNewsRequest
{
    public function __construct(
        public string $url
    )
    {
    }

}
