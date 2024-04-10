<?php

declare(strict_types=1);

namespace Alogachev\Homework\DataMapper\Mapper;

use Alogachev\Homework\DataMapper\Entity\Hall;
use PDO;

class HallMapper extends BaseMapper
{
    /**
     * @param Hall $entity
     * @return void
     */
    public function insert(object $entity): void
    {
        $query = $this->buildInsertQuery($entity);
        $prepared = $this->pdo->prepare($query);
        $prepared->bindValue(':name', $entity->getName(), PDO::PARAM_STR);
        $prepared->bindValue(':capacity', $entity->getCapacity(), PDO::PARAM_INT);
        $prepared->bindValue(':rows_count', $entity->getRowsCount(), PDO::PARAM_INT);
        $prepared->execute();
        // Меняем суррогатный id на реальный.
        $entity->setId((int)$this->pdo->lastInsertId());;
    }
}
