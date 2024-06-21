<?php

declare(strict_types=1);

namespace AlexanderGladkov\DB\SelectQuery;

use AlexanderGladkov\DB\Publisher\Publisher;
use AlexanderGladkov\DB\QueryResult\QueryResultInterface;
use InvalidArgumentException;
use PDO;
use PDOStatement;
use LogicException;

abstract class AbstractSelectQuery implements SelectQueryInterface
{
    public const DIRECTION_ASC = 'ASC';
    public const DIRECTION_DESC = 'DESC';

    private string $tableName = '';
    private array $whereClauses = [];
    private array $orderByClauses = [];

    public function __construct(private PDO $pdo, protected ?Publisher $publisher = null)
    {
    }

    public function from(string $table): static
    {
        $this->tableName = $table;
        return $this;
    }

    public function where(string $field, string|int $value): static
    {
        if ($field === '') {
            throw new InvalidArgumentException('field не должен быть пустым');
        }

        $this->whereClauses[$field] = $value;
        return $this;
    }

    public function orderBy(string $field, string $direction): static
    {
        if ($field === '') {
            throw new InvalidArgumentException('field не должен быть пустым');
        }

        if (!in_array($direction, $this->getPossibleDirections())) {
            throw new InvalidArgumentException('Неверное значение direction');
        }

        $this->orderByClauses[$field] = $direction;
        return $this;
    }

    abstract public function execute(): QueryResultInterface;

    protected function createStatement(): PDOStatement
    {
        $statement = $this->pdo->prepare($this->createQuerySql());
        $valueIndex = 0;
        foreach ($this->whereClauses as $fieldValue) {
            $valueIndex++;
            $type = is_int($fieldValue) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $statement->bindValue($valueIndex, $fieldValue, $type);
        }

        return $statement;
    }

    private function createQuerySql(): string
    {
        if ($this->tableName === '') {
            throw new LogicException('Таблица не указана');
        }

        $sql = 'SELECT * FROM ' . $this->tableName;
        if (count($this->whereClauses) > 0) {
            $whereSql = "";
            foreach ($this->whereClauses as $fieldName => $fieldValue) {
                if ($whereSql !== '') {
                    $whereSql .= ' AND ';
                }

                $whereSql .= $fieldName . ' = ?';
            }

            $sql .= ' WHERE ' . $whereSql;
        }

        if (count($this->orderByClauses) > 0) {
            $orderBySql = '';
            foreach ($this->orderByClauses as $fieldName => $sortDirection) {
                if ($orderBySql !== '') {
                    $orderBySql .= ', ';
                }

                $orderBySql .= $fieldName . ' ' . $sortDirection;
            }

            $sql .= ' ORDER BY ' . $orderBySql;
        }

        return $sql;
    }

    private function getPossibleDirections(): array
    {
        return [
            self::DIRECTION_ASC,
            self::DIRECTION_DESC,
        ];
    }
}
