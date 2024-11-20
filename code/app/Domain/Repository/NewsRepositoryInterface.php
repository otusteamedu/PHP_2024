<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\News;

interface NewsRepositoryInterface
{
    /**
     * @param integer $id
     * @return News|null
     */
    public function getById(int $id): ?News;

    /**
     *
     * @return News[]
     */
    public function getAll(): iterable;

    /**
     * @param News $news
     * @return void
     */
    public function save(News $news): void;

    /**
     * @param News $news
     * @return void
     */
    public function delete(News $news): void;
}
