<?php

declare(strict_types=1);

namespace AShutov\Hw17\DataMapper;

use PDO;
use PDOStatement;

class UserMapper
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
    }

    public function getById(int $id): Users
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);
        $result = $this->selectStatement->fetch();

        return new Users(
            $result['id'],
            $result['name'],
            $result['age'],
            $result['job'],
            $result['department_id']
        );
    }

    public function insert(array $rawUserData): Users
    {
        $this->insertStatement->execute([
            $rawUserData['name'],
            $rawUserData['age'],
            $rawUserData['job'],
            $rawUserData['department_id'],
        ]);

        return new Users(
            (int) $this->pdo->lastInsertId(),
            $rawUserData['name'],
            $rawUserData['age'],
            $rawUserData['job'],
            $rawUserData['department_id'],
        );
    }

    public function update(Users $user): bool
    {
        return $this->updateStatement->execute([
            $user->getName(),
            $user->getAge(),
            $user->getJob(),
            $user->getDepartmentId(),
            $user->getId()
        ]);
    }

    public function delete(Users $user): bool
    {
        return $this->deleteStatement->execute([$user->getId()]);
    }
}
