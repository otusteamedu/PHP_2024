<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\NameAge;
use App\Domain\Repository\NameAgeRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NameAge>
 */
class NameAgeRepository extends ServiceEntityRepository implements NameAgeRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NameAge::class);
    }

    public function save(NameAge $nameAge): NameAge
    {
        $this->getEntityManager()->persist($nameAge);
        $this->getEntityManager()->flush();
        return $nameAge;
    }

    public function findByName(string $name): ?NameAge
    {
        return $this->findOneBy(['name' => $name]);
    }
}
