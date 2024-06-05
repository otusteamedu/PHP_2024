<?php

declare(strict_types=1);

namespace Module\News\Infrastructure\Factory;

use Core\Domain\ValueObject\Uuid;
use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Module\News\Domain\Entity\News;
use Module\News\Domain\Entity\Status;
use Module\News\Domain\ValueObject\Title;
use Module\News\Domain\ValueObject\Url;
use Module\News\Infrastructure\Model\NewsModel;
use ReflectionException;
use ReflectionObject;

final class NewsMapper
{
    /**
     * @throws Exception
     */
    public function fromModel(NewsModel $model): News
    {
        $news = new News(
            new Uuid($model->id),
            new Url($model->url),
            new Title($model->title)
        );
        $reflectionObject = new ReflectionObject($news);
        $this->setDate($reflectionObject, $news, new DateTimeImmutable($model->date));
        $this->setStatus($reflectionObject, $news, $model->status);

        return $news;
    }

    /**
     * @throws Exception
     */
    public function fromCollection(Collection $newsModels): array
    {
        return array_map(function (NewsModel $model): News {
            return $this->fromModel($model);
        }, $newsModels->all());
    }

    /**
     * @throws ReflectionException
     */
    private function setDate(ReflectionObject $reflectionObject, News $news, DateTimeInterface $date): void
    {
        $reflectionProperty = $reflectionObject->getProperty('date');
        $reflectionProperty->setValue($news, $date);
    }

    /**
     * @throws ReflectionException
     */
    private function setStatus(ReflectionObject $reflectionObject, News $news, string $status): void
    {
        $reflectionProperty = $reflectionObject->getProperty('status');
        $reflectionProperty->setValue($news, Status::from($status));
    }
}
