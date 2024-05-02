<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

use App\Domain\Entity\News;

readonly class GetNewsListResponse
{
    /**
     * @param News[] $newsList
     */
    public function __construct(
        public array $newsList,
    ) {
    }
}
