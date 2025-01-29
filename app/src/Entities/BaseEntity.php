<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusDatabasePatternApp\Entities;

use SlavaMakhov\OtusDatabasePatternApp\Services\DatabaseService;
use Exception;

abstract class BaseEntity
{
    /** @var int */
    protected int $id;

    /** @var array */
    protected array $columns;

    /** @var string */
    protected string $tableName;

    /** @var string */
    protected string $entityName;

    /** @var DatabaseService */
    protected DatabaseService $db;

    public function __construct()
    {
        $this->columns = $this->getColumns();
        $this->tableName = $this->getTableName();
        $this->entityName = $this->getEntityName();
        $this->db = DatabaseService::getInstance();
    }

    /**
     * Метод возвращает список столбцов таблицы
     *
     * @return array
     */
    abstract protected function getColumns(): array;

    /**
     * Метод возвращает название таблицы
     *
     * @return string
     */
    abstract protected function getTableName(): string;

    /**
     * Метод возвращает название сущности на кирилице
     *
     * @return string
     */
    abstract protected function getEntityName(): string;

    /**
     * Метод возвращает id сущности
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Метод возвращает конкретную запись по её id
     * для определенной сущности
     *
     * @param int $id
     *
     * @return BaseEntity|null
     */
    public function findById(int $id): ?BaseEntity
    {
        $entity = $this->db->query(
            "SELECT * FROM " . $this->tableName . " WHERE id = ?;",
            [$id],
            static::class
        );

        return !empty($entity) ? $entity[0] : null;
    }

    /**
     * Метод добавляет сущность
     *
     * @param array $objectToInsert
     *
     * @return string
     */
    public function insert(array $objectToInsert): string
    {
        $insertInfo = [];
        $columns = implode(',', $this->columns);
        $arguments = array_fill(0, count($this->columns), '?');
        $values = implode(',', $arguments);

        foreach ($this->columns as $column) {
            if (array_key_exists($column, $objectToInsert)) {
                $insertInfo[] = $objectToInsert[$column];
            }
        }

        try {
            $this->db->query(
                "INSERT INTO {$this->tableName} ($columns) VALUES ($values)",
                $insertInfo,
                static::class
            );

            return $this->entityName . " с id: " . (int)$this->db->getPdo()->lastInsertId() . ", успешно создан!" . PHP_EOL;
        } catch (Exception $e) {
            echo "Ошибка при создании: " . $e->getMessage() . PHP_EOL;
        }
    }

    /**
     * Метод обновляет сущность
     *
     * @param array $objectToUpdate
     *
     * @return string
     */
    public function update(array $objectToUpdate): string
    {
        $updateInfo = [];
        $updateColumns = array_keys($objectToUpdate);
        $sqlCommand = "UPDATE {$this->tableName} SET ";
        $endColumnName = $updateColumns[count($updateColumns) - 1];

        foreach ($updateColumns as $itemObject) {
            foreach ($this->columns as $column) {
                if ($itemObject == $column) {
                    $sqlCommand .= $column . " = ? ";

                    if ($endColumnName != $itemObject) {
                        $sqlCommand .= ", ";
                    }

                    $updateInfo[] = $objectToUpdate[$column];
                }
            }
        }

        $sqlCommand .= "WHERE id = ?";
        $updateInfo[] = $this->getId();

        try {
            $this->db->query($sqlCommand, $updateInfo, static::class);

            return $this->entityName . " с id: " . $this->id . ", успешно обновлен!" . PHP_EOL;
        } catch (Exception $e) {
            echo "Ошибка при обновлении: " . $e->getMessage() . PHP_EOL;
        }
    }

    /**
     * Метод удаляет сущность
     *
     * @return string
     */
    public function delete(): string
    {
        try {
            $this->db->query("DELETE FROM {$this->tableName} WHERE id = ?", [$this->id], static::class);

            return $this->entityName . " с id: " . $this->id . ", успешно удален!" . PHP_EOL;
        } catch (Exception $e) {
            echo "Ошибка при удалении: " . $e->getMessage() . PHP_EOL;
        }
    }

}
