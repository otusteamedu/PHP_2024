<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

use App\Application\Dto\NewsDto;
use App\Domain\Entity\News;

readonly class GetNewsListResponse
{
    /**
     * @param NewsDto[] $news
     */
    public function __construct(
        public array $news,
        public int $offset,
        public int $limit,
        public int $total,
    ) {
    }
}
