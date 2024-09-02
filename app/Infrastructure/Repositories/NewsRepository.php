<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\NewsEntity;
use App\Domain\Factories\NewsFactoryInterface;
use App\Domain\Repositories\NewsRepositoryInterface;
use App\Infrastructure\Models\News;

class NewsRepository implements NewsRepositoryInterface
{
    public function __construct(
        private NewsFactoryInterface $newsFactory
    ) {}

    /**
     * {@inheritdoc}
     */
    public function all(): iterable
    {
        $models = News::all();

        $newsEntities = $models->map(static function (News $model): NewsEntity {
            return $this->newsFactory->create(
                $model->date,
                $model->url,
                $model->title
            );
        });

        return $newsEntities;
    }

    /**
     * {@inheritdoc}
     */
    public function findMultipleById(int ...$ids): iterable
    {
        $models = News::findMany($ids);

        $newsEntities = $models->map(static function (News $model): NewsEntity {
            return $this->newsFactory->create(
                $model->date,
                $model->url,
                $model->title
            );
        });

        return $newsEntities;
    }

    public function findById(int $id): ?NewsEntity
    {
        $model = News::find($id);

        if (! $model) {
            return null;
        }

        return $this->newsFactory->create(
            $model->date,
            $model->url,
            $model->title
        );
    }

    public function save(NewsEntity $newsEntity): void
    {
        $model = News::updateOrCreate(
            [
                'id' => $newsEntity->getId(),
            ],
            [
                'date' => (string) $newsEntity->getDate(),
                'url' => (string) $newsEntity->getUrl(),
                'title' => $newsEntity->getTitle(),
            ]
        );

        $newsEntity->setId($model->id);
    }

    public function delete(NewsEntity $newsEntity): void
    {
        News::destroy($newsEntity->getId());
    }
}
