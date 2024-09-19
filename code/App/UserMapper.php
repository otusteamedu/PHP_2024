<?php

namespace Otus\AppPDO;

use PDO;

class UserMapper
{
    private $pdo;
    private $identityMap = [];

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function find($id): ?User
    {
        if (isset($this->identityMap[$id])) {
            return $this->identityMap[$id];
        }

        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            $user = new User(
                $data['id'] ?? null,
                $data['name'] ?? null,
                $data['lastName'] ?? null,
                $data['phone'] ?? null,
                $data['email'] ?? null
            );
            $this->identityMap[$id] = $user;
            return $user;
        }

        return null;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM users');
        $users = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $data['id'];
            if (isset($this->identityMap[$id])) {
                $users[] = $this->identityMap[$id];
            } else {
                $user = new User(
                    $data['id'] ?? null,
                    $data['name'] ?? null,
                    $data['lastName'] ?? null,
                    $data['phone'] ?? null,
                    $data['email'] ?? null
                );
                $this->identityMap[$id] = $user;
                $users[] = $user;
            }
        }

        return $users;
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
        $id = (int) $this->pdo->lastInsertId();
        $user->setId($id);
        $this->identityMap[$id] = $user;

        return $id;
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
        $this->identityMap[$user->getId()] = $user;
    }

    public function delete($id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        unset($this->identityMap[$id]);
    }
}
