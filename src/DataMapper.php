<?php

declare(strict_types=1);

namespace Amikha1lov\DataMapper;

use InvalidArgumentException;
use PDO;
use ReflectionClass;

class DataMapper
{
    private PDO $db;
    private IdentityMap $identityMap;

    public function __construct(DatabaseConnection $databaseConnection)
    {
        $this->db = $databaseConnection->getConnection();
        $this->identityMap = new IdentityMap();
    }

    public function findById(string $className, int $id): ?Entity
    {

        $entity = $this->identityMap->get($className, $id);
        if ($entity instanceof $className) {
            return $entity;
        }


        $table = $this->getTable($className);

        $query = sprintf('SELECT * FROM "%s" WHERE id = :id', $table);
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $entity = $this->instantiateClass($className, $row);
        $this->identityMap->add($entity);

        return $entity;
    }

    public function findAll(string $className): array
    {
        $table = $this->getTable($className);

        $query = sprintf('SELECT * FROM "%s"', $table);
        $stmt = $this->db->query($query);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $entities = [];
        foreach ($rows as $row) {

            $entity = $this->identityMap->get($className, $row['id']);
            if ($entity === null) {
                $entity = $this->instantiateClass($className, $row);
                $this->identityMap->add($entity);
            }
            $entities[] = $entity;
        }

        return $entities;
    }

    private function instantiateClass(string $className, array $row): ?Entity
    {
        try {
            $reflection = new ReflectionClass($className);

            $constructor = $reflection->getConstructor();

            if ($constructor) {

                $params = $constructor->getParameters();
                $arguments = [];

                foreach ($params as $param) {
                    $name = $param->getName();

                    if (!array_key_exists($name, $row)) {
                        throw new InvalidArgumentException("Не найден аргумент: $name");
                    }
                    $arguments[] = $row[$name];
                }

                return $reflection->newInstanceArgs($arguments);
            }

        } catch (\ReflectionException $exception) {
            echo $exception->getMessage();
        }

        return null;
    }

    /**
     * @param string $className
     * @return string
     */
    private function getTable(string $className): string
    {
        return strtolower(
            basename(
                str_replace('\\', '/', $className)
            )
        );
    }
}
