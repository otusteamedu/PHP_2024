<?php

declare(strict_types=1);

namespace App\Models;

use App\Main\Connection;
use PDOStatement;

class User
{
    private Connection $connection;

    private ?int $id = null;
    private ?string $firstName = null;
    private ?string $lastName = null;
    private ?string $email = null;

    private array $changes = [];

    public function __construct()
    {
        $this->connection = new Connection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;
        $this->changes['first_name'] = $firstName;

        return $this;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;
        $this->changes['last_name'] = $lastName;

        return $this;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        $this->changes['email'] = $email;

        return $this;
    }

    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function findOneById(int $id): self|null
    {
        $result = $this->connection
            ->queryAll(
                'SELECT id, first_name, last_name, email FROM users WHERE id = :id',
                ['id' => $id],
            );

        $user = !empty($result) ? $result[0] : null;

        return $result ? (new self())->setId($user['id'])
        ->setFirstName($user['first_name'])
        ->setLastName($user['last_name'])
        ->setEmail($user['email']) : null;
    }

    public function getAll(): array
    {
        $result = $this->connection
            ->queryAll(
                'SELECT id, first_name, last_name, email FROM users'
            );

        return array_map(function (array $user) {
            return (new self())->setId($user['id'])
                ->setFirstName($user['first_name'])
                ->setLastName($user['last_name'])
                ->setEmail($user['email']);
        }, $result);
    }

    public function create(): int
    {
        $this->connection->query(
            'INSERT INTO users (first_name, last_name, email) VALUES (:first_name, :last_name, :email)',
            [
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'email' => $this->email
            ]
        );

        $this->id = (int)$this->connection->lastInsertId();

        return $this->id;
    }

    public function update(): int
    {
        $columns = [];

        foreach ($this->changes as $key => $value) {
            if ($key !== 'id') {
                $columns[] = "`$key`" . '=' . ":{$key}";
            }
        }

        $columns = implode(', ', $columns);

        $result = $this->connection->execute(
            "UPDATE users SET $columns WHERE id = :id",
            $this->changes + ['id' => $this->getId()],
        );

        $this->changes = [];

        return $result;
    }

    public function delete(int|null $id = null): false|PDOStatement
    {
        $result = $this->connection->query(
            'DELETE FROM users WHERE id = :id',
            [
                'id' => $id ?? $this->id
            ]
        );

        $this->id = null;

        return $result;
    }
}
