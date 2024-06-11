<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Domain\Event;

use Kagirova\Hw21\Domain\Entity\Category;

class NewsIsCreatedEvent
{
    public function __construct(
        private int $newsId,
        private Category $category,
    ) {
    }

    public function getCategoryId(): int
    {
        return $this->category->getId();
    }

    public function getCategoryName(): string
    {
        return $this->category->getName();
    }

    public function getNewsId(): int
    {
        return $this->newsId;
    }
}
