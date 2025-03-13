<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Infrastructure\Factory\CommonNewsFactory;

class DatabaseNewsRepository implements NewsRepositoryInterface
{
    public function __construct(private CommonNewsFactory $factory)
    {
    }

    public function get(array $ids = []): array
    {
        $dbNewsList = \App\Infrastructure\Models\News::query()
            ->when(!blank($ids), function ($q) use ($ids) {
                $q->whereIn('id', $ids);
            })
            ->get();

        /** @var News[] $news */
        $newsList = [];

        foreach ($dbNewsList as $newsDB) {
            $news = $this->factory->create($newsDB->name, $newsDB->url, $newsDB->created_at);

            $reflectionProperty = new \ReflectionProperty(News::class, 'id');
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($news, $newsDB->id);

            $newsList[] = $news;
        }

        return $newsList;
    }

    public function save(News $news): News
    {
        $newsDB = \App\Infrastructure\Models\News::query()->create([
            'name' => $news->getName()->getName(),
            'url' => $news->getUrl()->getUrl(),
            'created_at' => $news->getCreatedAt(),
        ]);

        $reflectionProperty = new \ReflectionProperty(News::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($news, $newsDB->id);

        return $news;
    }
}
