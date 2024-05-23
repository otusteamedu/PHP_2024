<?php

declare(strict_types=1);

namespace App\Domain\News;

use App\Domain\News\Exceptions\NewsNotFoundException;
use App\Domain\User\User;

interface NewsRepository
{
    /**
     * @return News[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return News
     * @throws NewsNotFoundException
     */
    public function findNewsOfId(int $id): News;

    /**
     * @param News $news
     * @return News
     */
    public function save(News $news): News;

    public function update(News $news): News;

    /**
     * @param News $news
     */
    public function delete(News $news): void;
}