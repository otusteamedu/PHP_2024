<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\News;

interface NewsRepositoryInterface
{
    public function addAndSaveNews(News $news): void;

    /**
     * @return News[]
     */
    public function getNewsList(): array;
}
