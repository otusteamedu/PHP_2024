<?php

declare(strict_types=1);

namespace Module\News\Infrastructure\Repository;

use Core\Domain\ValueObject\Uuid;
use Exception;
use Module\News\Domain\Entity\News;
use Module\News\Domain\Repository\NewsRepositoryInterface;
use Module\News\Infrastructure\Factory\NewsMapper;
use Module\News\Infrastructure\Factory\NewsModelMapper;
use Module\News\Infrastructure\Model\NewsModel;

use function array_map;

final readonly class NewsRepository implements NewsRepositoryInterface
{
    public function __construct(
        private NewsMapper $mapper,
        private NewsModelMapper $modelMapper
    ) {
    }

    public function create(News $news): void
    {
        $this->modelMapper->fromEntity($news)->save();
    }

    public function update(News $news): void
    {
        /** @var NewsModel $model */
        $model = NewsModel::query()->where('id', $news->getId())->firstOrFail();
        $this->modelMapper->fromEntity($news, $model)->save();
    }

    /**
     * @throws Exception
     */
    public function getAll(): array
    {
        return $this->mapper->fromCollection(
            NewsModel::query()->get()
        );
    }

    /**
     * @throws Exception
     */
    public function getAllByIds(Uuid ...$ids): array
    {
        if (empty($ids)) {
            return [];
        }

        $ids = array_map(static fn (Uuid $id): string => $id->getValue(), $ids);

        $collection = NewsModel::query()
            ->whereIn('id', $ids)
            ->get()
        ;

        return $this->mapper->fromCollection($collection);
    }

    /**
     * @throws Exception
     */
    public function getById(Uuid $id): News
    {
        /** @var NewsModel $model */
        $model = NewsModel::query()
            ->where('id', $id->getValue())
            ->firstOrFail()
        ;

        return $this->mapper->fromModel($model);
    }
}
