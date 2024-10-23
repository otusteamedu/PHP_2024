<?php

namespace App\Application\DataMapper\Interface;

use App\Domain\Entity\AbstractEntity;

interface MapperInterface
{
    public function findById(string $id): ?AbstractEntity;

    /**
     * @param array $criteriaArray
     * @return AbstractEntity[]|null
     */
    public function findByCriteria(array $criteriaArray): ?array;

    public function insert(AbstractEntity $entity): ?AbstractEntity;

    public function update(AbstractEntity $entity);

    public function delete(AbstractEntity $entity);
}
