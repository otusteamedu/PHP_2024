<?php

namespace App\Domain\Interface\Factory;

use App\Domain\Interface\Entity\EntityInterface;

interface EntityFactoryInterface
{
    public function makeEntity(string $entityClass, ...$parameters): EntityInterface;
}
