<?php

declare(strict_types=1);

namespace Hukimato\App\Models\DataMapper;

use Exception;
use PDO;
use PDOStatement;

abstract class AbstractDataMapper
{
//    protected const className = null;

    private PDO          $pdo;

    private PDOStatement $selectStatement;

    private PDOStatement $insertStatement;

    private PDOStatement $updateStatement;

    private PDOStatement $deleteStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $tableName = static::getTableName();
        $this->selectStatement = $pdo->prepare(
            "SELECT * FROM $tableName WHERE id = ?"
        );
        $this->insertStatement = $pdo->prepare(
            static::constructInsertQuery()
        );
        $this->updateStatement = $pdo->prepare(
            static::constructUpdateQuery()
        );
        $this->deleteStatement = $pdo->prepare(
            "DELETE FROM $tableName WHERE id = ?"
        );
    }

    protected static function constructInsertQuery()
    {
        $className = static::getModelName();
        $tableName = static::getTableName();

        $reflect = new \ReflectionClass($className);
        $props = $reflect->getProperties();
        $insertQuery = "INSERT INTO $tableName (";
        foreach ($props as $prop) {
            $insertQuery .= $prop->getName() . ", ";
        }
        $insertQuery .= ") VALUES (" . str_repeat('?, ', count($props)) . ")";
        return $insertQuery;
    }

    protected static function constructUpdateQuery()
    {
        $className = static::getModelName();
        $tableName = static::getTableName();

        $reflect = new \ReflectionClass($className);
        $props = $reflect->getProperties();
        $insertQuery = "INSERT $tableName SET ";
        foreach ($props as $prop) {
            $insertQuery .= $prop->getName() . " = ? ";
        }
        return $insertQuery;
    }

    protected static function constructPrimaryKeyCondition()
    {
        $className = static::getModelName();
        $tableName = static::getTableName();

        $reflect = new \ReflectionClass($className);
        $props = $reflect->getProperties();
        $insertQuery = "WHERE  ";
        foreach ($props as $prop) {
            $insertQuery .= $prop->getName() . " = ? ";
        }
        return $insertQuery;
    }

    /**
     * @return string Имя таблицы в БД
     * @throws Exception
     */
    protected static function getTableName(): string
    {
        return '';
        throw new Exception('You must declare getTableName in ' . static::class);
    }

    /**
     * @return string Имя модели, в которую маппятся данные
     * @throws Exception
     */
    protected static function getModelName(): string
    {
        return '';
        throw new Exception('You must declare getModelName in ' . static::class);
    }
}