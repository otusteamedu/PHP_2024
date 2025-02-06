<?php

declare(strict_types=1);

//https://github.com/ab-budaev/otus-php-database-patterns-lesson/blob/master/src/DataMapper/User.php
namespace Skudashkin\Hw16\DataMapper;

use PDO;
use PDOStatement;

class UserMapper
{
    private PDO          $pdo;

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
            'INSERT INTO users (first_name, last_name, email) VALUES (?, ?, ?)'
        );
        $this->updateStatement = $pdo->prepare(
            'UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE id = ?'
        );
        $this->deleteStatement = $pdo->prepare(
            'DELETE FROM users WHERE id = ?'
        );
    }

    public function findById(int $id): User
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);

        $result = $this->selectStatement->fetch();

        return new User(
            $result['id'],
            $result['first_name'],
            $result['last_name'],
            $result['email'],
        );
    }

    public function insert(array $rawUserData): User
    {
        $this->insertStatement->execute([
            $rawUserData['first_name'],
            $rawUserData['last_name'],
            $rawUserData['email'],
        ]);

        return new User(
            (int)$this->pdo->lastInsertId(),
            $rawUserData['first_name'],
            $rawUserData['last_name'],
            $rawUserData['email'],
        );
    }

    public function update(User $user): bool
    {
        return $this->updateStatement->execute([
            $user->getFirstName(),
            $user->getLastName(),
            $user->getEmail(),
            $user->getId(),
        ]);
    }

    public function delete(User $user): bool
    {
        return $this->deleteStatement->execute([$user->getId()]);
    }
}