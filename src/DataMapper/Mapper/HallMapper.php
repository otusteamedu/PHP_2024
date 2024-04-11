<?php

declare(strict_types=1);

namespace Alogachev\Homework\DataMapper\Mapper;

use Alogachev\Homework\DataMapper\Entity\Hall;
use Alogachev\Homework\DataMapper\Query\QueryItem;
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

    /**
     * @return Hall[]
     */
    public function findAll(): array
    {
        $this->selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectAllStatement->execute();
        $result = $this->selectAllStatement->fetchAll();

        return $result
            ? array_map(
                static fn($hall) => new Hall(
                    $hall['id'],
                    $hall['name'],
                    $hall['capacity'],
                    $hall['rows_count']
                ),
                $result
            )
            : [];
    }

    public function finById(QueryItem $queryItem): ?Hall
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->bindValue(
            ':' . $queryItem->getName(),
            $queryItem->getValue(),
            $queryItem->getType()
        );

        $this->selectStatement->execute();
        $result = $this->selectStatement->fetch();

        return !empty($result)
            ? new Hall(
                $result['id'],
                $result['name'],
                $result['capacity'],
                $result['rows_count']
            )
            : null;
    }
}
