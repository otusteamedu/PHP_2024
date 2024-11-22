<?php

namespace App\Domain\Contract\Infrastructure\Factory;

use App\Domain\Contract\Domain\Entity\EntityInterface;

/**
 * @template T
 */
interface EntityFactoryInterface
{
    /**
     * @param class-string $entityClass
     * @param ...$parameters
     * @return T
     */
    public function makeEntity(string $entityClass, ...$parameters): EntityInterface;
}
