<?php

declare(strict_types=1);

namespace Module\News\Infrastructure\Repository;

use Core\Domain\ValueObject\Uuid;
use Exception;
use Module\News\Domain\Entity\NewsCollection;
use Module\News\Domain\Factory\NewsFactory;
use Module\News\Domain\Repository\NewsQueryRepositoryInterface;
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
    public function getAll(): NewsCollection
    {
        $data = NewsModel::query()->get()->toArray();
        return $this->factory->createCollectionByRaw($data);
    }

    /**
     * @throws Exception
     */
    public function getAllByIds(Uuid $id, Uuid ...$ids): NewsCollection
    {
        $ids[] = $id;
        $ids = array_map(static fn (Uuid $id): string => $id->getValue(), $ids);

        $data = NewsModel::query()
            ->whereIn('id', $ids)
            ->get()
            ->toArray()
        ;

        return $this->factory->createCollectionByRaw($data);
    }
}
