<?php

declare(strict_types=1);

namespace Dsergei\Hw13;

use Dsergei\Hw5\MysqlConnection;

class Credit
{
    public int $id;

    public string $name;

    public int $bankId;

    public static \PDO $connection;

    public function __construct()
    {
        self::$connection = MysqlConnection::getInstance();
    }

    public function __get(String $prop): mixed
    {
        return $this->${$prop};
    }

    public function __set(String $prop, mixed $value)
    {
        $this->${$prop} = $value;
    }


    public function findById(int $id): ?self
    {
        $sql = "SELECT * FROM credit WHERE id = :id";
        $result = self::$connection->prepare($sql);
        $result->bindParam(':id', $id, \PDO::PARAM_INT);
        $result->execute();
        return $result->fetchObject(__CLASS__);
    }

    public function findByBankId(int $bankId): ?self
    {
        $sql = "SELECT * FROM credit WHERE bankId = :id";
        $result = self::$connection->prepare($sql);
        $result->bindParam(':bankId', $bankId, \PDO::PARAM_INT);
        $result->execute();
        return $result->fetchObject(__CLASS__);
    }

    public function findAll(): ?array
    {
        $sql = "SELECT * FROM credit";
        $result = self::$connection->prepare($sql);
        $result->execute();
        return $result->fetchALL(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM credit WHERE id = :id";
        $result = self::$connection->prepare($sql);
        $result->bindParam(':id', $id, \PDO::PARAM_INT);

        if ($result->execute())
        {
            return $result->fetch(\PDO::FETCH_ASSOC);
        }
    }

    public function save()
    {
        if (empty($this->id))
        {
            $sql = "INSERT INTO credit (id, name, bankId) VALUES (:id, :name, :bankId)";
        } else {
            $sql = "UPDATE credit SET name = :name, bankId = :bankId WHERE id = :id";
        }

        $result = self::$connection->prepare($sql);
        return $result->execute((array)$this);
    }
}
