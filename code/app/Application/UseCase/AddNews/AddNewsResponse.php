<?php

declare(strict_types=1);

namespace App\Application\UseCase\AddNews;

class AddNewsResponse
{
    public function __construct(
        public int $id
    ) {}
}
