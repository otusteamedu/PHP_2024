<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\News;
use App\Domain\Exception\EntityNotFoundException;
use App\Domain\Repository\NewsRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class NewsRepository extends ServiceEntityRepository implements NewsRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }

    public function save(News $news): void
    {
        $this->getEntityManager()->persist($news);
        $this->getEntityManager()->flush();
    }

    public function findAllNews(int $offset, int $limit): array
    {
        $qb = $this->createQueryBuilder('n');

        return $qb
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('n.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findAllByIds(array $ids): array
    {
        $news = $this->findBy([
            'id' => $ids,
        ]);

        if (0 === count($news)) {
            throw new EntityNotFoundException('News not found');
        }

        return $news;
    }

    public function getNewsCount(): int
    {
        return $this->createQueryBuilder('n')
            ->select('COUNT(n.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
