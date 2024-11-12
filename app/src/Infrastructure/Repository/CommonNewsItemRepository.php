<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\NewsItem;
use App\Domain\Factory\NewsItemFactoryInterface;
use App\Domain\Repository\NewsItemRepositoryInterface;
use App\Infrastructure\Doctrine\Entity\NewsItem as DoctrineNewsItem;
use App\Infrastructure\Doctrine\Repository\NewsItemRepository;

class CommonNewsItemRepository implements NewsItemRepositoryInterface
{
    public function __construct(
        private readonly NewsItemRepository $ormRepository,
        private readonly NewsItemFactoryInterface $commonFactory,
    ) {
    }

    public function findAll(): array
    {
        $items = $this->ormRepository->findAll();

        return $this->convertList($items);
    }

    public function findBy(array $params): array
    {
        $items = $this->ormRepository->findBy($params);

        return $this->convertList($items);
    }

    public function findById(int $id): ?NewsItem
    {
        /**
         * @var DoctrineNewsItem $item
         */
        $item = $this->ormRepository->find($id);

        return $this->convertItem($item);
    }

    public function save(NewsItem $newsItem): void
    {
        if ($newsItem->getId()) {
            $item = $this->ormRepository->find($newsItem->getId());
        } else {
            $item = new DoctrineNewsItem();
        }

        $item->setTitle($newsItem->getTitle()->getValue())
            ->setUrl($newsItem->getUrl()->getValue())
            ->setDate(\DateTime::createFromImmutable($newsItem->getDate()->getValue()))
        ;

        $this->ormRepository->registry->getManager()->persist($item);
        $this->ormRepository->registry->getManager()->flush();

        $reflectionProperty = new \ReflectionProperty(NewsItem::class, 'id');
        $reflectionProperty->setAccessible(true);

        $reflectionProperty->setValue($newsItem, $item->getId());
    }

    public function delete(NewsItem $newsItem): void
    {
        if ($newsItem->getId()) {
            $item = $this->ormRepository->find($newsItem->getId());
            $this->ormRepository->registry->getManager()->remove($item);
        }

        unset($newsItem);
    }

    private function convertList($items): array
    {
        $result = [];
        $reflectionProperty = new \ReflectionProperty(NewsItem::class, 'id');
        $reflectionProperty->setAccessible(true);

        /**
         * @var DoctrineNewsItem $item
         */
        foreach ($items as $item) {
            $domainItem = $this->commonFactory->create(
                $item->getTitle(),
                $item->getUrl(),
                \DateTimeImmutable::createFromMutable($item->getDate())
            );

            $reflectionProperty->setValue($domainItem, $item->getId());
            $result[] = $domainItem;
        }

        return $result;
    }

    private function convertItem(DoctrineNewsItem $item): NewsItem
    {
        $reflectionProperty = new \ReflectionProperty(NewsItem::class, 'id');
        $reflectionProperty->setAccessible(true);
        $domainItem = $this->commonFactory->create(
            $item->getTitle(),
            $item->getUrl(),
            \DateTimeImmutable::createFromMutable($item->getDate())
        );

        $reflectionProperty->setValue($domainItem, $item->getId());

        return $domainItem;
    }
}
