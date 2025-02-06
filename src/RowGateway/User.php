<?php

declare(strict_types=1);

//https://github.com/ab-budaev/otus-php-database-patterns-lesson/blob/master/src/RowGateway/User.php
namespace SKudashkin\hw16;

use PDO;
use PDOStatement;

class User
{
    private ?int         $id        = null;

    private ?string      $firstName = null;

    private ?string      $lastName  = null;

    private ?string      $email     = null;

    private PDO          $pdo;

    private PDOStatement $insertStatement;

    private PDOStatement $updateStatement;

    private PDOStatement $deleteStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
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

        return $this;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function insert(): int
    {
        $this->insertStatement->execute([
            $this->firstName,
            $this->lastName,
            $this->email,
        ]);

        $this->id = (int)$this->pdo->lastInsertId();

        return $this->id;
    }

    public function update(): bool
    {
        return $this->updateStatement->execute([
            $this->firstName,
            $this->lastName,
            $this->email,
            $this->id,
        ]);
    }

    public function delete(): bool
    {
        $result = $this->deleteStatement->execute([$this->id]);

        $this->id = null;

        return $result;
    }
}