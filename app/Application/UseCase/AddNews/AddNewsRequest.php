<?php

namespace Application\UseCase\AddNews;

class AddNewsRequest
{
    public function __construct(
        public string $url
    )
    {
    }

}
