<?php

declare(strict_types=1);

namespace AShutov\Hw17\RowGateway;

use PDO;
use PDOStatement;

class Users
{
    private ?int $id = null;
    private ?string $name = null;
    private ?int $age  = null;
    private ?string $job = null;
    private ?int $departmentId = null;
    private PDO $pdo;
    private PDOStatement $insertStatement;
    private PDOStatement $updateStatement;
    private PDOStatement $deleteStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->insertStatement = $pdo->prepare(
            'INSERT INTO users (name, age, job, department_id) VALUES (?, ?, ?, ?)'
        );
        $this->updateStatement = $pdo->prepare(
            'UPDATE users SET name = ?, age = ?, job = ?, department_id = ? WHERE id = ?'
        );
        $this->deleteStatement = $pdo->prepare(
            'DELETE FROM users WHERE id = ?'
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function getJob(): ?string
    {
        return $this->job;
    }

    public function getDepartmentId(): ?string
    {
        return $this->departmentId;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function setJob(?string $job): self
    {
        $this->job = $job;

        return $this;
    }

    public function setDepartmentId(?int $departmentId): self
    {
        $this->departmentId = $departmentId;

        return $this;
    }

    public function insert(): int
    {
        $this->insertStatement->execute([
            $this->name,
            $this->age,
            $this->job,
            $this->departmentId,
        ]);
        $this->id = (int) $this->pdo->lastInsertId();

        return $this->id;
    }

    public function update(): bool
    {
        return $this->updateStatement->execute([
            $this->name,
            $this->age,
            $this->job,
            $this->departmentId,
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
