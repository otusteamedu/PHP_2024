<?php

namespace App\Application\UseCase\SubmitNews;

class SubmitNewsRequest
{
    public function __construct(
        public readonly string $url
    )
    {
    }
}
