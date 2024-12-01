<?php

/**
 * @noinspection PhpMultipleClassDeclarationsInspection
 */

declare(strict_types=1);

namespace App\MediaMonitoring\Infrastructure\Repository;

use App\MediaMonitoring\Domain\Entity\Post;
use App\MediaMonitoring\Domain\Repository\PostRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrinePostRepository extends ServiceEntityRepository implements PostRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findAll(): array
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->orderBy('p.id', 'ASC')
        ;

        return $queryBuilder->getQuery()->execute();
    }

    public function findByIds(array $ids): array
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->where('p.id IN (:ids)')
            ->orderBy('p.id', 'ASC')
            ->setParameter('ids', $ids)
        ;

        return $queryBuilder->getQuery()->execute();
    }

    public function save(Post $post): Post
    {
        $entityManager = $this->getEntityManager();

        $entityManager->persist($post);
        $entityManager->flush();

        return $post;
    }
}
