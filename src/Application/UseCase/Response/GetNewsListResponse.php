<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

use App\Application\UseCase\Response\DTO\NewsResponseDto;

readonly class GetNewsListResponse
{
    public function __construct(
        /**
         * @var NewsResponseDto $newsList
         */
        public array $newsList,
    ) {
    }
}
