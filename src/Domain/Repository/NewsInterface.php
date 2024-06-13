<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\News;

interface NewsInterface
{
    /**
     * @param News $news
     * @return void
     */
    public function save(News $news): void;

    /**
     * @param array $params
     * @return News[]
     */
    public function findByParams(array $params): array;
}
