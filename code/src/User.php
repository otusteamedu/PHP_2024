<?php
namespace AlexAgapitov\OtusComposerProject;

use PDO;
use PDOStatement;

class User {
    private ?int $id = null;
    private ?string $first_name = null;
    private ?string $last_name = null;
    private ?string $second_name = null;
    private bool $first_name_updated = false;
    private bool $last_name_updated = false;
    private bool $second_name_updated = false;

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
        if ($this->first_name !== $first_name) {
            $this->first_name_updated = true;
        }
        $this->first_name = $first_name;

        return $this;
    }

    public function setLastName(string $last_name): self
    {
        if ($this->last_name !== $last_name) {
            $this->last_name_updated = true;
        }
        $this->last_name = $last_name;

        return $this;
    }

    public function setSecondName(string $second_name): self
    {
        if ($this->second_name !== $second_name) {
            $this->second_name_updated = true;
        }
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
        $values = $columns = [];
        if ($this->first_name_updated) {
            $values[] = $this->first_name;
            $columns[] = "first_name = ?";
        }
        if ($this->last_name_updated) {
            $values[] = $this->last_name;
            $columns[] = "last_name = ?";
        }
        if ($this->second_name_updated) {
            $values[] = $this->second_name;
            $columns[] = "second_name = ?";
        }
        if (empty($values)) {
            return false;
        }
        $sql_q = "UPDATE users SET ".implode(', ', $columns)." WHERE id = ?";
        $this->updateStatement = !empty($this->updateStatement) && $this->updateStatement->queryString === $sql_q
            ? $this->updateStatement
            : $this->conn->prepare($sql_q);

        $values[] = $this->id;
        $exec = $this->updateStatement->execute($values);

        if ($exec) {
            $this->first_name_updated = false;
            $this->second_name_updated = false;
            $this->last_name_updated = false;
        }

        return $exec;
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