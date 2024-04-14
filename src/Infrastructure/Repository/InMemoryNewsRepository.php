<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;

class InMemoryNewsRepository implements NewsRepositoryInterface
{
    /**
     * @var News[]
     */
    private array $news = [];
    public function save(News $news): void
    {
        $id = count($this->news) + 1;
        $createDate = new \DateTime();
        $reflectionProperty = new \ReflectionProperty(News::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($news, $id);

        $reflectionProperty = new \ReflectionProperty(News::class, 'createdDate');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($news, $createDate);
        $this->news[] = $news;
    }

    /**
     * @return News[]
     */
    public function getAll(): array
    {
        return $this->news;
    }

    public function getByIds(array $ids): array
    {
        $filtered_news = array_filter(
            $this->news,
            static fn (News $news): bool => in_array($news->getId(), $ids)
        );

        return array_values($filtered_news);
    }
}