<?php

declare(strict_types=1);

namespace Alogachev\Homework\DataMapper\IdentityMap;

use Alogachev\Homework\DataMapper\ORM\Column;
use Alogachev\Homework\DataMapper\ORM\Id;
use ReflectionClass;

abstract class BaseIdentityMap
{
    protected array $entities = [];

    public function get(mixed $id): ?object
    {
        return $this->entities[$id] ?? null;
    }

    public function add(object $entity): void
    {
        $reflectionClass = new ReflectionClass($entity);
        $id = '';
        // Формируем id, на случай если он составной.
        foreach ($reflectionClass->getProperties() as $property) {
            $idAttribute = $property->getAttributes(Id::class);
            $idColumn = !empty($idAttribute) ? $property->getAttributes(Column::class)[0]->newInstance() : null;
            if (!isset($idColumn)) {
                continue;
            }

            $id .= $property->getValue($entity);
        }

        if (!$this->isExists($id)) {
            $this->entities[$id] = $entity;
        }
    }

    public function isExists(mixed $id): bool
    {
        return isset($this->entities[$id]);
    }
}
