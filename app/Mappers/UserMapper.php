<?php

namespace App\Mappers;

use App\Entities\User;
use PDO;

class UserMapper extends AbstractMapper
{
    public static function findById(int $id): ?User
    {
        $statement = self::$pdo->prepare('SELECT * FROM users WHERE id = :id');
        $statement->execute(['id' => $id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new User($row['id'], $row['name'], $row['email']);
        }

        return null;
    }

    public static function findAll(): array
    {
        $statement = self::$pdo->query('SELECT * FROM users');
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        $users = [];

        foreach ($rows as $row) {
            $users[] = new User($row['id'], $row['name'], $row['email']);
        }

        return $users;
    }

    public static function save(User $user): void
    {
        if ($user->getId()) {
            $statement = self::$pdo->prepare('UPDATE users SET name = :name, email = :email WHERE id = :id');
            $statement->execute([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'id' => $user->getId()
            ]);
        } else {
            $statement = self::$pdo->prepare('INSERT INTO users (name, email) VALUES (:name, :email)');
            $statement->execute([
                'name' => $user->getName(),
                'email' => $user->getEmail()
            ]);
            $user->setId(self::$pdo->lastInsertId());
        }
    }
}
