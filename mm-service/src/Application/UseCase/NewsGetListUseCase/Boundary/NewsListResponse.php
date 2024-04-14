<?php

declare(strict_types=1);

namespace App\Application\UseCase\NewsGetListUseCase\Boundary;

use App\Domain\Entity\News;

class NewsListResponse
{
    /**
     * @param NewsGetResponse[] $items
     */
    public function __construct(
        private array $items
    ) {
    }

    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param News[] $boundaryItems
     */
    public static function fromBoundary(array $boundaryItems): self
    {
        return new self(
            array_map(fn (News $news) => NewsGetResponse::fromBoundary($news), $boundaryItems),
        );
    }
}
