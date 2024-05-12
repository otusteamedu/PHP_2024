<?php

declare(strict_types=1);

namespace AShutov\Hw17\TableGateway;

use PDO;
use PDOStatement;

class Users
{
    private PDO $pdo;
    private PDOStatement $selectStatement;
    private PDOStatement $selectAllStatement;
    private PDOStatement $insertStatement;
    private PDOStatement $updateStatement;
    private PDOStatement $deleteStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStatement = $pdo->prepare(
            'SELECT * FROM users WHERE id = ?'
        );
        $this->insertStatement = $pdo->prepare(
            'INSERT INTO users (name, age, job, department_id) VALUES (?, ?, ?, ?)'
        );
        $this->updateStatement = $pdo->prepare(
            'UPDATE users SET name = ?, age = ?, job = ?, department_id = ? WHERE id = ?'
        );
        $this->deleteStatement = $pdo->prepare(
            'DELETE FROM users WHERE id = ?'
        );
        $this->selectAllStatement = $pdo->query('SELECT * FROM users');
    }

    public function getById(int $id): array
    {
        $this->selectStatement->execute([$id]);

        return $this->selectStatement->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsers(): array
    {
        $allUsers = [];
        $this->selectAllStatement->execute();

        while ($row = $this->selectAllStatement->fetch(PDO::FETCH_ASSOC)) {
            $allUsers[] = $row;
        }

        return $allUsers;
    }

    public function insert(
        string $name,
        int $age,
        string $job,
        int $department_id
    ): int {
        $this->insertStatement->execute([
            $name,
            $age,
            $job,
            $department_id
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function update(
        int $id,
        string $name,
        int $age,
        string $job,
        int $department_id
    ): bool {
        return $this->updateStatement->execute([
            $name,
            $age,
            $job,
            $department_id,
            $id
        ]);
    }

    public function delete(int $id): bool
    {
        return $this->deleteStatement->execute([$id]);
    }
}
