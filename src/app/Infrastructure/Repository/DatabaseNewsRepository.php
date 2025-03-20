<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\News as NewsEntity;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Infrastructure\Factory\CommonNewsFactory;
use App\Infrastructure\Models\News as NewsDB;

class DatabaseNewsRepository implements NewsRepositoryInterface
{
    public function __construct(private CommonNewsFactory $factory)
    {
    }

    public function all(): array
    {
        $dbNewsList = NewsDB::all();

        /** @var NewsEntity[] $news */
        $newsList = [];

        foreach ($dbNewsList as $newsDB) {
            $news = $this->createEntityFromModel($newsDB);
            $this->setIdToEntityFromModel($news, $newsDB->id);

            $newsList[] = $news;
        }

        return $newsList;
    }

    public function findByIds(array $ids): array
    {
        $dbNewsList = NewsDB::query()
            ->when(!blank($ids), function ($q) use ($ids) {
                $q->whereIn('id', $ids);
            })
            ->get();

        /** @var NewsEntity[] $news */
        $newsList = [];

        foreach ($dbNewsList as $newsDB) {
            $news = $this->createEntityFromModel($newsDB);
            $this->setIdToEntityFromModel($news, $newsDB->id);

            $newsList[] = $news;
        }

        return $newsList;
    }

    public function save(NewsEntity $news): void
    {
        $newsDB = NewsDB::query()->create([
            'name' => $news->getName()->getName(),
            'url' => $news->getUrl()->getUrl(),
            'created_at' => $news->getCreatedAt(),
        ]);

        $this->setIdToEntityFromModel($news, $newsDB->id);
    }

    private function createEntityFromModel($newsModel)
    {
        return $this->factory->create($newsModel->name, $newsModel->url, $newsModel->created_at);
    }

    private function setIdToEntityFromModel(NewsEntity $news, $id)
    {
        $reflectionProperty = new \ReflectionProperty(NewsEntity::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($news, $id);
    }
}
