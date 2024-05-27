<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

use App\Application\UseCase\Response\DTO\AddedNewsDto;

readonly class AddNewsResponse
{
    public function __construct(
        public AddedNewsDto $news,
    ) {
    }
}
