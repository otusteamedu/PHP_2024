<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Domain\RepositoryInterface;

use Kagirova\Hw21\Domain\Entity\News;

interface StorageInterface
{
    public function getAllNews();

    public function getNews($newsId);

    public function saveNews(News $news): int;

    public function subscribeToNews(int $categoryId);

    public function getCategoryId($categoryName);

    public function addCategory($categoryName);

    public function getCategoryName(int $categoryId);
}
