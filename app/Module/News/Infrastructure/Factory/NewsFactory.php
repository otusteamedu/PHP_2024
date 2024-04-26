<?php

declare(strict_types=1);

namespace Module\News\Infrastructure\Factory;

use Core\Domain\ValueObject\Uuid;
use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Module\News\Domain\Entity\News;
use Module\News\Domain\ValueObject\Title;
use Module\News\Domain\ValueObject\Url;
use Module\News\Infrastructure\Model\NewsModel;
use ReflectionObject;

final class NewsFactory
{
    /**
     * @throws Exception
     */
    public function create(NewsModel $model): News
    {
        $news = new News(
            new Uuid($model->id),
            new Url($model->url),
            new Title($model->title)
        );
        $this->setDate($news, new DateTimeImmutable($model->date));

        return $news;
    }

    /**
     * @throws Exception
     */
    public function createByCollection(Collection $newsModels): array
    {
        return array_map(function (NewsModel $model): News {
            return $this->create($model);
        }, $newsModels->all());
    }

    private function setDate(News $news, DateTimeInterface $date): void
    {
        $reflectionObject = new ReflectionObject($news);
        $reflectionProperty = $reflectionObject->getProperty('date');
        $reflectionProperty->setValue($news, $date);
    }
}
