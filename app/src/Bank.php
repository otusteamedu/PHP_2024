<?php

declare(strict_types=1);

namespace Dsergei\Hw13;

use Dsergei\Hw5\MysqlConnection;

class Bank
{
    public int $id;

    public string $name;

    public static \PDO $connection;

    public array $credits;

    public function __construct(\PDO $pdo)
    {
        self::$connection = $pdo;
    }

    public function __get(string $prop): mixed
    {
        return $this->${$prop};
    }

    public function __set(string $prop, mixed $value)
    {
        $this->${$prop} = $value;
    }


    public function findById(int $id): ?self
    {
        $sql = "SELECT * FROM bank WHERE id = :id";
        $result = self::$connection->prepare($sql);
        $result->bindParam(':id', $id, \PDO::PARAM_INT);
        $result->execute();
        return $result->fetchObject(__CLASS__);
    }

    public function findAll(): ?array
    {
        $sql = "SELECT * FROM product";
        $result = self::$connection->prepare($sql);
        $result->execute();
        return $result->fetchALL(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM product WHERE id = :id";
        $result = self::$connection->prepare($sql);
        $result->bindParam(':id', $id, \PDO::PARAM_INT);

        if ($result->execute()) {
            return $result->fetch(\PDO::FETCH_ASSOC);
        }
    }

    public function save()
    {
        if (empty($this->id)) {
            $sql = "INSERT INTO bank (id, name) VALUES (:id, :name)";
        } else {
            $sql = "UPDATE bank SET name = :name WHERE id = :id";
        }

        $result = self::$connection->prepare($sql);
        return $result->execute((array)$this);
    }

    public function getCredits()
    {
        if (empty($this->credits)) {
            $this->credits = (new Credit(self::$connection))->findById($this->id);
        }

        return $this->credits;
    }
}
