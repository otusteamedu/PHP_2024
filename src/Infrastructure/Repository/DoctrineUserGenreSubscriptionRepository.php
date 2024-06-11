<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Application\Repository\DTO\FindUserByGenreSubscriptionDto;
use App\Domain\Entity\UserGenreSubscription;
use App\Domain\Repository\IUserGenreSubscriptionRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineUserGenreSubscriptionRepository extends ServiceEntityRepository  implements IUserGenreSubscriptionRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserGenreSubscription::class);
    }

    public function findUsersSubscribedToGenre(FindUserByGenreSubscriptionDto $query): array
    {
        return $this->createQueryBuilder('ugs')
            ->where('ugs.genre = :genre')
            ->setParameter('genre', $query->genre)
            ->getQuery()
            ->getResult();
    }

    public function save(UserGenreSubscription $subscription): void
    {
        $this->getEntityManager()->persist($subscription);
        $this->getEntityManager()->flush();
    }
}
