<?php

namespace App\Infrastructure\DataMapper\Interface;

use App\Domain\Entity\AbstractEntity;
use App\Domain\Model\AbstractModel;

interface DataMapperInterface
{
    public function findById(string $id): ?AbstractEntity;

    /**
     * @param array $criteriaArray
     * @return AbstractEntity[]|null
     */
    public function findByCriteria(array $criteriaArray): ?array;

    public function insert(AbstractEntity $entity): ?AbstractEntity;

    public function update(AbstractModel $model): bool;

    public function delete(AbstractEntity $entity): bool;
}
