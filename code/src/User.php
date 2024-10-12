<?php
namespace AlexAgapitov\OtusComposerProject;

use PDO;
use PDOStatement;

class User {
    private ?int $id = null;
    private ?string $first_name = null;
    private ?string $last_name = null;
    private ?string $second_name = null;

    private PDO $conn;

    private PDOStatement $selectStatement;
    private PDOStatement $insertStatement;
    private PDOStatement $updateStatement;
    private PDOStatement $deleteStatement;

    public function connection(PDO $conn) {

        $this->conn = $conn;

        $this->selectStatement = $this->conn->prepare("
            SELECT * FROM users WHERE id = ?
        ");

        $this->insertStatement = $this->conn->prepare("
            INSERT INTO users (first_name, last_name, second_name) VALUES (?, ?, ?)
        ");

        $this->updateStatement = $this->conn->prepare("
            UPDATE users SET first_name = ?, last_name = ?, second_name = ? WHERE id = ?
        ");

        $this->deleteStatement = $this->conn->prepare("
            DELETE FROM users WHERE id = ?
        ");
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }
    public function getLastName(): ?string
    {
        return $this->last_name;
    }
    public function getSecondName(): ?string
    {
        return $this->second_name;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function setSecondName(string $second_name): self
    {
        $this->second_name = $second_name;

        return $this;
    }
    public function findById(int $id)
    {
        $this->selectStatement->execute([$id]);

        return $this->selectStatement->fetch(PDO::FETCH_OBJ);
    }

    public function insert(): int
    {
        $this->insertStatement->execute([
            $this->first_name,
            $this->last_name,
            $this->second_name
        ]);

        $this->id = (int)$this->conn->lastInsertId();

        return $this->id;
    }
    public function update(): bool
    {
        if (empty($this->id)) return false;
        return $this->updateStatement->execute([
            $this->first_name,
            $this->last_name,
            $this->second_name,
            $this->id
        ]);
    }

    public function delete(int $id): bool
    {
        $res = $this->deleteStatement->execute([$id]);

        if ($res) {
            $this->id = null;
        }

        return $res;
    }

    public function getAll()
    {
        $this->selectStatement->execute([$id]);

        return $this->selectStatement->fetchAll(PDO::FETCH_OBJ);
    }

    private function getClassName()
    {
        return 'User';
    }
}