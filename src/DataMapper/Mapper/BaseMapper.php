<?php

declare(strict_types=1);

namespace Alogachev\Homework\DataMapper\Mapper;

use Alogachev\Homework\DataMapper\ORM\Column;
use Alogachev\Homework\DataMapper\ORM\Id;
use Alogachev\Homework\DataMapper\ORM\Table;
use PDO;
use ReflectionClass;

abstract class BaseMapper
{
    public function __construct(
        protected PDO $pdo
    ) {
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

    protected function buildSelectQuery(): string
    {
        return '';
    }
}
