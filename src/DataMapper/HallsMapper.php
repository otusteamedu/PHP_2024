<?php

declare(strict_types=1);

namespace hw17\DataMapper;

class HallsMapper
{
    private PDO $pdo;
    private PDOStatement $selectStatement;
    private PDOStatement $insertStatement;
    private PDOStatement $updateStatement;
    private PDOStatement $deleteStatement;

    public function __construct(
        PDO $pdo
    ) {
        $this->pdo = $pdo;
        $this->selectStatement = $pdo->prepare(
            'SELECT * FROM halls WHERE id = ?'
        );
        $this->insertStatement = $pdo->prepare(
            'INSERT INTO halls (hallName, numberOfSeats, isPremium) VALUES (?, ?, ?)'
        );
        $this->updateStatement = $pdo->prepare(
            'UPDATE halls SET hallName = ?, numberOfSeats = ?, isPremium = ? WHERE id = ?'
        );
        $this->deleteStatement = $pdo->prepare(
            'DELETE FROM halls WHERE id = ?'
        );
    }

    public function findById(int $id): Halls
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);

        $result = $this->selectStatement->fetch();

        return new Halls(
            $result['id'],
            $result['hallName'],
            $result['numberOfSeats'],
            $result['isPremium']
        );
    }

    public function insert(array $rawHallsData): Halls
    {
        $this->insertStatement->execute([
            $rawHallsData['hallName'],
            $rawHallsData['numberOfSeats'],
            $rawHallsData['isPremium']
        ]);

        return new Halls(
            (int)$this->pdo->lastInsertId(),
            $rawHallsData['hallName'],
            $rawHallsData['numberOfSeats'],
            $rawHallsData['isPremium']
        );
    }

    public function update(Halls $halls): bool
    {
        return $this->updateStatement->execute([
            $halls->getHallName(),
            $halls->getNumberOfSeats(),
            $halls->getIsPremium()
        ]);
    }
}
