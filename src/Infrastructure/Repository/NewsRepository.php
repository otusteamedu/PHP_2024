<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Repository\NewsInterface;
use App\Domain\Entity\News;
use Doctrine\ORM\EntityManagerInterface;

class NewsRepository implements NewsInterface
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function save(News $news): void
    {
        $this->em->persist($news);
        $this->em->flush();
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        $persister = $this->em->getUnitOfWork()->getEntityPersister(News::class);

        return $persister->loadAll($criteria, $orderBy, $limit, $offset);
    }
}
