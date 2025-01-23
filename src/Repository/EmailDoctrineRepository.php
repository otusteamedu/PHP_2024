<?php

/**
 * @noinspection PhpMultipleClassDeclarationsInspection
 */

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Email;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends ServiceEntityRepository<Email>
 */
class EmailDoctrineRepository extends ServiceEntityRepository implements EmailRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Email::class);
    }

    public function findOneById(string $id): ?Email
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function save(Email $email): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->persist($email);
        $entityManager->flush();
    }
}
