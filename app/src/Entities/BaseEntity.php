<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusDatabasePatternApp\Entities;

use SlavaMakhov\OtusDatabasePatternApp\Services\DatabaseService;

abstract class BaseEntity
{
    /** @var int */
    protected int $id;

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
    public static function findById(int $id): ?BaseEntity
    {
        $db = DatabaseService::getInstance();
        $entity = $db->query(
            "SELECT * FROM " . static::getTableName() . " WHERE id = ?;",
            [$id],
            static::class
        );

        return !empty($entity) ? $entity[0] : null;
    }

    /**
     * Метод возвращает все записи
     * для определенной сущности
     *
     * @return array
     */
    public static function findAll(): array
    {
        $db = DatabaseService::getInstance();
        $entities = $db->query('SELECT * FROM ' . static::getTableName() . ';', [], static::class);

        return !empty($entities) ? $entities : [];
    }

    /**
     * Метод возвращает название таблицы
     *
     * @return string
     */
    abstract protected static function getTableName(): string;
}
