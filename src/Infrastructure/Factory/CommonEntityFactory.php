<?php

namespace App\Infrastructure\Factory;

use App\Domain\Interface\Entity\EntityInterface;
use App\Domain\Interface\Factory\EntityFactoryInterface;

class CommonEntityFactory implements EntityFactoryInterface
{
    /**
     * @param string $entityClass
     * @param ...$parameters
     * @return EntityInterface
     */
    public function makeEntity(string $entityClass, ...$parameters): EntityInterface
    {
        return new $entityClass(...$parameters);
    }
}
