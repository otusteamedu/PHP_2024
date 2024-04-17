<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Repository\NewsInterface;
use App\Domain\Entity\News;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method News[] findAll()
 */
class NewsRepository extends ServiceEntityRepository implements NewsInterface
{
    public function __construct(
        ManagerRegistry $registry,
        private EntityManagerInterface $entityManager
    ) {
        parent::__construct($registry, News::class);
    }

    public function save(News $news): void
    {
        $this->entityManager->persist($news);
        $this->entityManager->flush();
    }

    public function getTitles(array $ids): array
    {
        return $this->createQueryBuilder('n')
            ->select('n.title.value as title')
            ->andWhere('n.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult();
    }
}