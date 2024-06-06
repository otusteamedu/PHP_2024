<?php

declare(strict_types=1);

namespace App\DataMapper;

use App\Dto\CreateUserDto;
use App\Dto\UpdateUser;
use App\User;

class UserDataMapper
{
    public function __construct(private \PDO $db)
    {
    }

    public function findById(int $userId): User
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $query->bindValue(":id", $userId);
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if (!$row) {
            throw new \DomainException('User not found');
        }
        return new User((int) $row['id'], $row['name'], $row['email']);
    }

    public function getAll(int $offsetId, int $limit): array
    {
        $query = $this->db->query("SELECT * FROM users WHERE id > $offsetId ORDER BY id LIMIT {$limit}");
        $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(
            static fn (array $row): User => new User((int) $row['id'], $row['name'], $row['email']),
            $rows
        );
    }

    public function findByEmail(string $email): User
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE email = :id");
        $query->bindValue(":email", $email);
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if (!$row) {
            throw new \DomainException('User not found');
        }
        return new User((int) $row['id'], $row['name'], $row['email']);
    }

    public function create(CreateUserDto $createUser): int
    {
        $this->db->prepare("INSERT INTO users (name, email) VALUES (:name, :email)")
            ->execute(
                [
                    ":name" => $createUser->name,
                    ":email" => $createUser->email,
                ]
            );
        return (int) $this->db->lastInsertId();
    }

    public function update(int $userId, UpdateUser $user): void
    {
        $updateParams = [];
        $updateFieldConditions = [];

        if ($user->name) {
            $updateParams[':name'] = $user->name;
            $updateFieldConditions[] = 'name = :name';
        }
        if ($user->email) {
            $updateParams[':email'] = $user->email;
            $updateFieldConditions[] = 'email = :email';

        }

        $updateParams[':id'] = $userId;

        $this->db->prepare(
            "UPDATE users SET " . implode(',', $updateFieldConditions) . " WHERE id = :id"
        )->execute($updateParams);
    }

    public function delete(User $user): void
    {
        $this->db->prepare("DELETE FROM users WHERE id = :id")->execute([':id' => $user->getId()]);
    }
}
