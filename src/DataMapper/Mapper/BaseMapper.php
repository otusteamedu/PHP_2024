<?php

declare(strict_types=1);

namespace Alogachev\Homework\DataMapper\Mapper;

use Alogachev\Homework\DataMapper\ORM\Column;
use Alogachev\Homework\DataMapper\ORM\Id;
use Alogachev\Homework\DataMapper\ORM\Table;
use PDO;
use PDOStatement;
use ReflectionClass;
use ReflectionException;

abstract class BaseMapper
{
    protected PDOStatement $selectStatement;
    protected PDOStatement $selectAllStatement;

    /**
     * @throws ReflectionException
     */
    public function __construct(
        protected string $entityClass,
        protected PDO $pdo
    ) {
        $this->selectStatement = $this->buildSelectQuery();
        $this->selectAllStatement = $this->buildSelectAllQuery();
    }

    protected function buildInsertQuery(object $entity): string
    {
        $reflectionClass = new ReflectionClass($entity);
        $tableAttribute = $reflectionClass->getAttributes(Table::class)[0]->newInstance();
        // Если у аттрибута тип Id с автоинкрементной стратегией, то не добавляем его в запрос и не требуем его наличия.
        $filteredProperties = array_filter(
            $reflectionClass->getProperties(),
            function($property) {
                $idAttribute = $property->getAttributes(Id::class);
                $idInstance = !empty($idAttribute) ? $idAttribute[0]->newInstance() : null;

                return empty($idAttribute) || empty($idInstance) || !$idInstance->isAutoIncrementStrategy();
            }
        );

        $columns = array_map(
            function ($property) {
                $attribute = $property->getAttributes(Column::class)[0]->newInstance();
                return $attribute->name;
            },
            $filteredProperties
        );

        $placeholders = array_map(
            function ($column) {
                return ':'. $column;
            },
            $columns
        );

        return sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $tableAttribute->name,
            implode(', ', $columns),
            implode(', ', $placeholders)
        );
    }

    /**
     * @throws ReflectionException
     */
    private function buildSelectQuery(): PDOStatement
    {
        $reflectionClass = new ReflectionClass($this->entityClass);
        $tableAttribute = $reflectionClass->getAttributes(Table::class)[0]->newInstance();
        $query = 'SELECT * FROM ' . $tableAttribute->name;

        foreach ($reflectionClass->getProperties() as $property) {
            $idAttribute = $property->getAttributes(Id::class);
            $idColumn = !empty($idAttribute) ? $property->getAttributes(Column::class)[0]->newInstance() : null;
            if (isset($idColumn)) {
                $query .= ' WHERE ' . $idColumn->name.' = :'. $idColumn->name;
            }
        }

        return $this->pdo->prepare($query);
    }

    /**
     * @throws ReflectionException
     */
    private function buildSelectAllQuery(): PDOStatement
    {
        $reflectionClass = new ReflectionClass($this->entityClass);
        $tableAttribute = $reflectionClass->getAttributes(Table::class)[0]->newInstance();
        $query = 'SELECT * FROM ' . $tableAttribute->name;

        return $this->pdo->prepare($query);
    }
}
