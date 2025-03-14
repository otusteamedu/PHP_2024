<?php

namespace App\Application\UseCase\GetNews;

class GetNewsRequest
{
    public function __construct(
        public readonly int $id
    ) {
    }
}
