<?php

namespace App\Infrastructure\Factory;

use App\Domain\Contract\Domain\Entity\EntityInterface;
use App\Domain\Contract\Infrastructure\Factory\EntityFactoryInterface;

/**
 * @template T
 */
class CommonEntityFactory implements EntityFactoryInterface
{
    /**
     * @param string $entityClass
     * @param ...$parameters
     * @return T
     */
    public function makeEntity(string $entityClass, ...$parameters): EntityInterface
    {
        return new $entityClass(...$parameters);
    }
}
