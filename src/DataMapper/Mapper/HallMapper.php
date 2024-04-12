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
     *
     * @return void
     */
    public function insert(Hall $entity): void
    {
        $prepared = $this->insertStatement;
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
        $identityId = (string)$queryItem->getValue();
        if ($this->identityMap->isExists($identityId)) {
            return $this->identityMap->get($identityId);
        }

        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->bindValue(
            ':' . $queryItem->getName(),
            $queryItem->getValue(),
            $queryItem->getType()
        );

        $this->selectStatement->execute();
        $result = $this->selectStatement->fetch();
        $hall = !empty($result)
            ? new Hall(
                $result['id'],
                $result['name'],
                $result['capacity'],
                $result['rows_count']
            )
            : null;

        if (isset($hall)) {
            $this->identityMap->add($hall);
        }

        return !empty($result)
            ? new Hall(
                $result['id'],
                $result['name'],
                $result['capacity'],
                $result['rows_count']
            )
            : null;
    }

    public function update(Hall $entity): void
    {
        $prepared = $this->updateStatement;
        $prepared->bindValue(':name', $entity->getName(), PDO::PARAM_STR);
        $prepared->bindValue(':capacity', $entity->getCapacity(), PDO::PARAM_INT);
        $prepared->bindValue(':rows_count', $entity->getRowsCount(), PDO::PARAM_INT);
        $prepared->bindValue(':id', $entity->getId(), PDO::PARAM_INT);
        $prepared->execute();
    }

    public function delete(Hall $entity): void
    {
        $prepared = $this->deleteStatement;
        $prepared->bindValue(':id', $entity->getId(), PDO::PARAM_INT);
        $prepared->execute();
    }
}
