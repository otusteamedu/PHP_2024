<?php

declare(strict_types=1);

namespace Module\News\Domain\Repository;

use Module\News\Domain\Entity\News;

interface NewsCommandRepositoryInterface
{
    public function create(News $news): void;
}
