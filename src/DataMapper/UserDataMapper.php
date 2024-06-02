<?php

declare(strict_types=1);

namespace App\DataMapper;

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
        if (empty($row)) {
            throw new \DomainException('User not found');
        }
        return new User((int) $row['id'], (string) $row['name']);
    }
}
