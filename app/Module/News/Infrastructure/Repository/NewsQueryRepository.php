<?php

declare(strict_types=1);

namespace Module\News\Infrastructure\Repository;

use Core\Domain\ValueObject\Uuid;
use Exception;
use Module\News\Domain\Repository\NewsQueryRepositoryInterface;
use Module\News\Infrastructure\Factory\NewsFactory;
use Module\News\Infrastructure\Model\NewsModel;

use function array_map;

final readonly class NewsQueryRepository implements NewsQueryRepositoryInterface
{
    public function __construct(
        private NewsFactory $factory
    ) {
    }

    /**
     * @throws Exception
     */
    public function getAll(): array
    {
        return $this->factory->createByCollection(
            NewsModel::query()->get()
        );
    }

    /**
     * @throws Exception
     */
    public function getAllByIds(Uuid $id, Uuid ...$ids): array
    {
        $ids[] = $id;
        $ids = array_map(static fn (Uuid $id): string => $id->getValue(), $ids);

        $collection = NewsModel::query()
            ->whereIn('id', $ids)
            ->get()
        ;

        return $this->factory->createByCollection($collection);
    }
}
