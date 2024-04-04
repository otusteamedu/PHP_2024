<?php

declare(strict_types=1);

namespace Hukimato\App\Models\DataMapper;

use Exception;
use PDO;
use PDOStatement;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

abstract class AbstractDataMapper
{

    protected PDO $pdo;

    protected PDOStatement $selectStatement;

    protected PDOStatement $insertStatement;

    protected PDOStatement $updateStatement;

    protected PDOStatement $deleteStatement;

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function __construct()
    {
        $tableName = static::getTableName();

        $this->pdo = static::getPDO();
        $this->selectStatement = $this->pdo->prepare(
            "SELECT * FROM $tableName " . static::constructPrimaryKeyCondition()
        );
        $this->insertStatement = $this->pdo->prepare(
            static::constructInsertQuery()
        );
        $this->updateStatement = $this->pdo->prepare(
            static::constructUpdateQuery()
        );
        $this->deleteStatement = $this->pdo->prepare(
            "DELETE FROM $tableName " . static::constructPrimaryKeyCondition()
        );
    }


    /**
     * @throws ReflectionException
     * @throws Exception
     */
    protected static function constructInsertQuery(): string
    {
        $propsNames = static::getPropertiesNames(static::getModelClassProperties());
        $tableName = static::getTableName();

        $query = "INSERT INTO $tableName ";
        $query .= "(" . implode(", ", $propsNames) . ") ";
        $query .= "VALUES (" . str_repeat('?, ', count($propsNames) - 1) . "?" . ")";
        return $query;
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    protected static function constructUpdateQuery(): string
    {
        $propsNames = static::getPropertiesNames(static::getModelClassProperties());
        $tableName = static::getTableName();

        $query = "UPDATE $tableName SET ";
        $query .= implode(" = ?, ", $propsNames) . " = ? ";
        $query .= static::constructPrimaryKeyCondition();
        return $query;
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    protected static function constructPrimaryKeyCondition(): string
    {
        $props = static::getModelClassProperties();

        $primaryKeyProps = array_filter($props, function (ReflectionProperty $prop) {
            return !empty($prop->getAttributes(PrimaryKey::class));
        });

        $propsNames = static::getPropertiesNames($primaryKeyProps);

        $query = "WHERE  ";
        $query .= implode(" = ? AND ", $propsNames) . " = ? ";
        return $query;
    }

    protected static function filterProperties(array $props,  $attributeClassName): array
    {
        return array_filter($props, function (ReflectionProperty $prop) use ($attributeClassName) {
            return !empty($prop->getAttributes($attributeClassName));
        });
    }

    /**
     * @param ReflectionProperty[] $props
     * @return string[]
     */
    protected static function getPropertiesNames(array $props): array
    {
        return array_map(function (ReflectionProperty $prop) {
            return $prop->getName();
        }, $props);
    }

    /**
     * Метод возвращает массив скалярных свойств класса
     * @return string[]
     * @throws ReflectionException
     * @throws Exception
     */
    protected static function getScalarProperties(): array
    {
        return (new ReflectionClass(static::getModelName()))->getProperties(ReflectionProperty::IS_PUBLIC);
    }

    /**
     * @return ReflectionProperty[] - все свойства модели
     * @throws ReflectionException
     * @throws Exception
     */
    protected static function getModelClassProperties(): array
    {
        return (new ReflectionClass(static::getModelName()))->getProperties();
    }

    protected static function getPDO(): PDO
    {
        $dsnStr = sprintf(
            "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
            'postgresql',
            '5432',
            'hukimato',
            'hukimato',
            'hukimato',
        );

        return new PDO($dsnStr);
    }


    /**
     * @return string Имя таблицы в БД
     * @throws Exception
     */
    protected static function getTableName(): string
    {
        throw new Exception('You must declare getTableName in ' . static::class);
    }

    /**
     * @return string Имя модели, в которую маппятся данные
     * @throws Exception
     */
    protected static function getModelName(): string
    {
        throw new Exception('You must declare getModelName in ' . static::class);
    }

    public function debugQueryStrings()
    {
        print_r($this->selectStatement->queryString . PHP_EOL);
        print_r($this->insertStatement->queryString . PHP_EOL);
        print_r($this->updateStatement->queryString . PHP_EOL);
        print_r($this->deleteStatement->queryString . PHP_EOL);
    }
}