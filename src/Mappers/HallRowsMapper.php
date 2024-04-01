<?php

declare(strict_types=1);

namespace AleksandrOrlov\Php2024\Mappers;

use AleksandrOrlov\Php2024\Entities\Hall;
use AleksandrOrlov\Php2024\Entities\HallRow;
use AleksandrOrlov\Php2024\Collections\HallRowsCollection;
use PDO;
use PDOStatement;

class HallRowsMapper
{
    private PDO $pdo;

    private PDOStatement $selectStatement;

    private PDOStatement $insertStatement;

    private PDOStatement $updateStatement;

    private PDOStatement $deleteStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStatement = $pdo->prepare(
            'SELECT * FROM hall_rows WHERE id = ?'
        );
        $this->insertStatement = $pdo->prepare(
            'INSERT INTO hall_rows (hall_id, number, capacity) VALUES (?, ?, ?)'
        );
        $this->updateStatement = $pdo->prepare(
            'UPDATE hall_rows SET hall_id = ?, number = ?, capacity = ? WHERE id = ?'
        );
        $this->deleteStatement = $pdo->prepare(
            'DELETE FROM hall_rows WHERE id = ?'
        );
    }

    public function findAll(): HallRowsCollection
    {
        $select = $this->pdo->prepare(
            'SELECT * FROM hall_rows'
        );
        $select->setFetchMode(PDO::FETCH_ASSOC);
        $select->execute();

        $result = $select->fetchAll();

        $hallRowsCollection = new HallRowsCollection();

        foreach ($result as $row) {
            $hallRow = new HallRow(
                $row['id'],
                $row['hall_id'],
                $row['number'],
                $row['capacity'],
            );

            $hallId = $hallRow->getHallId();

            $reference = function () use ($hallId) {
                $select = $this->pdo->prepare(
                    'SELECT * FROM halls WHERE id = ?'
                );
                $select->setFetchMode(PDO::FETCH_ASSOC);
                $select->execute([$hallId]);

                $result = $select->fetch();

                return new Hall($result['id'], $result['name']);
            };

            $hallRow->setRepoReference($reference);

            $hallRowsCollection->add($hallRow);
        }

        return $hallRowsCollection;
    }

    public function findById(int $id): HallRow
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);

        $result = $this->selectStatement->fetch();

        return new HallRow(
            $result['id'],
            $result['hall_id'],
            $result['number'],
            $result['capacity'],
        );
    }

    public function insert(array $raw): HallRow
    {
        $this->insertStatement->execute([
            $raw['hall_id'],
            $raw['number'],
            $raw['capacity'],
        ]);

        return new HallRow(
            (int)$this->pdo->lastInsertId(),
            $raw['hall_id'],
            $raw['number'],
            $raw['capacity'],
        );
    }

    public function update(HallRow $hallRow): bool
    {
        return $this->updateStatement->execute([
            $hallRow->getHallId(),
            $hallRow->getNumber(),
            $hallRow->getCapacity(),
            $hallRow->getId(),
        ]);
    }

    public function delete(HallRow $hallRow): bool
    {
        return $this->deleteStatement->execute([$hallRow->getId()]);
    }
}
