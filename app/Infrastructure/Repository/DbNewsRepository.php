<?php

namespace App\Infrastructure\Repository;

use App\Domain\Builder\NewsBuilder;
use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use ReflectionProperty;

class DbNewsRepository implements NewsRepositoryInterface
{
    public function __construct()
    {
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
            $news = (new NewsBuilder())
                ->setTitle($newsModel->title)
                ->setDate(new \DateTimeImmutable($newsModel->date))
                ->setAuthor($newsModel->author)
                ->setCategory($newsModel->category)
                ->setText($newsModel->text)
                ->build();

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
                         'date' => $news->getDate(),
                         'author' => $news->getAuthor()->getValue(),
                         'category' => $news->getCategory()->getValue(),
                         'text' => $news->getText(),
                     ]
            );

        $reflectionProperty = new ReflectionProperty(News::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($news, $newsModel->id);
    }
}
