<?php

declare(strict_types=1);

namespace Module\News\Infrastructure\Repository;

use Module\News\Domain\Entity\News;
use Module\News\Domain\Repository\NewsCommandRepositoryInterface;
use Module\News\Infrastructure\Factory\NewsModelFactory;

final readonly class NewsCommandRepository implements NewsCommandRepositoryInterface
{
    public function __construct(
        private NewsModelFactory $factory
    ) {
    }

    public function create(News $news): void
    {
        $this->factory->create($news)->save();
    }
}
