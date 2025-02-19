<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\News;
use App\Domain\Factory\NewsFactoryInterface;
use App\Domain\Repository\NewsRepositoryInterface;
use ReflectionProperty;

class DbNewsRepository implements NewsRepositoryInterface
{
    public function __construct(
        private readonly NewsFactoryInterface $newsFactory
    ) {
    }

    /**
     * @inheritDoc
     */
    public function findAll(): iterable
    {
        return $this->findByIds([]);
    }

    public function findById(int $id): ?News
    {
        return $this->findByIds([$id])[0] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function findByIds(array $ids): iterable
    {
        $newsModels = \App\Infrastructure\Models\News::query()
            ->when(!empty($ids), function ($query) use ($ids) {
                $query->whereIn('id', $ids);
            })
            ->get();

        $reflectionProperty = new ReflectionProperty(News::class, 'id');
        $reflectionProperty->setAccessible(true);
        $newsList = [];
        foreach ($newsModels as $newsModel) {
            $news = $this->newsFactory->create($newsModel->url, $newsModel->title, new \DateTimeImmutable($newsModel->date));
            $reflectionProperty->setValue($news, $newsModel->id);
            $newsList[] = $news;
        }

        return $newsList;
    }

    public function save(News $news): void
    {
        $newsModel = \App\Infrastructure\Models\News::query()
            ->create([
                         'title' => $news->getTitle()->getValue(),
                         'url' => $news->getUrl()->getValue(),
                         'date' => $news->getDate(),
                     ]
            );

        $reflectionProperty = new ReflectionProperty(News::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($news, $newsModel->id);
    }
}
