<?php

namespace Otus\AppPDO;

use PDO;

class UserMapper
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function find($id): ?User
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new User(
                $data['id'] ?? null,
                $data['name'] ?? null,
                $data['lastName'] ?? null,
                $data['phone'] ?? null,
                $data['email'] ?? null
            );
        }

        return null;
    }

    public function insert(User $user): int
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO users (name, lastName, phone, email) 
            VALUES (:name, :lastName, :phone, :email)
        ');
        $stmt->execute([
            'name' => $user->getName(),
            'lastName' => $user->getLastName(),
            'phone' => $user->getPhone(),
            'email' => $user->getEmail()
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function update(User $user): void
    {
        $stmt = $this->pdo->prepare('
            UPDATE users 
            SET name = :name, lastName = :lastName, phone = :phone, email = :email
            WHERE id = :id
        ');
        $stmt->execute([
            'name' => $user->getName(),
            'lastName' => $user->getLastName(),
            'phone' => $user->getPhone(),
            'email' => $user->getEmail(),
            'id' => $user->getId()
        ]);
    }

    public function delete($id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
