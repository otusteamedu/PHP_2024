<?php

declare(strict_types=1);

namespace App\DataMapper;

use App\Dto\CreateUserDto;
use App\User;

class UserDataMapper
{
    public function __construct(private \PDO $db)
    {
    }

    public function getUserById(int $userId): User
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $query->bindValue(":id", $userId);
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if (!$row) {
            throw new \DomainException('User not found');
        }
        return new User((int) $row['id'], $row['name'], $row['email']);
    }

    public function getUsers(): array
    {
        $query = $this->db->query("SELECT * FROM users");
        $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(
            static fn (array $row): User => new User((int) $row['id'], $row['name'], $row['email']),
            $rows
        );
    }

    public function findUserByEmail(string $email): User
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE email = :id");
        $query->bindValue(":email", $email);
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if (!$row) {
            throw new \DomainException('User not found');
        }
        return new User((int) $row['id'], $row['name'], $row['email']);
    }

    public function createUser(CreateUserDto $createUser): int
    {
        $query = $this->db->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
        $query->bindValue(":name", $createUser->name);
        $query->bindValue(":email", $createUser->email);
        $query->execute();
        return (int) $this->db->lastInsertId();
    }
}
