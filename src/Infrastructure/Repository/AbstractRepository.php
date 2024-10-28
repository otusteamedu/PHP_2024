<?php

namespace App\Infrastructure\Repository;

use App\Domain\Interface\Entity\EntityInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;

/**
 * @template T
 */
abstract class AbstractRepository
{
    public function __construct(protected readonly EntityManagerInterface $entityManager)
    {
    }

    protected function flush(): void
    {
        $this->entityManager->flush();
    }

    /**
     * @param T $entity
     * @return EntityInterface
     */
    protected function store(EntityInterface $entity): EntityInterface
    {
        $this->entityManager->persist($entity);
        $this->flush();

        return $entity;
    }

    /**
     * @param T $entity
     * @throws ORMException
     */
    public function refresh(EntityInterface $entity): void
    {
        $this->entityManager->refresh($entity);
    }
}
