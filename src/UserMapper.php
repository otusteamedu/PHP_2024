<?php

namespace App;

use PDO;

class UserMapper {
    private PDO $pdo;
    private IdentityMap $identityMap;

    public function __construct(PDO $pdo, IdentityMap $identityMap) {
        $this->pdo = $pdo;
        $this->identityMap = $identityMap;
    }

    public function find(int $id): ?User {
        if ($user = $this->identityMap->get(User::class, $id)) {
            return $user;
        }

        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        $user = new User($data['name'], $data['email']);
        $this->identityMap->add($user, $data['id']);

        return $user;
    }

    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM users");
        $users = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($user = $this->identityMap->get(User::class, $data['id'])) {
                $users[] = $user;
                continue;
            }

            $user = new User($data['name'], $data['email']);
            $this->identityMap->add($user, $data['id']);
            $users[] = $user;
        }

        return $users;
    }

    public function insert(User $user): void {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
        $stmt->execute(['name' => $user->name, 'email' => $user->email]);
        $id = (int)$this->pdo->lastInsertId();
        $this->identityMap->add($user, $id);
    }

    public function update(User $user): void {
        $stmt = $this->pdo->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        $stmt->execute(['name' => $user->name, 'email' => $user->email]);
    }
}