<?php

declare(strict_types=1);

namespace Amikha1lov\DataMapper\Mappers;

use Amikha1lov\DataMapper\DatabaseConnection;
use Amikha1lov\DataMapper\Entity;
use Amikha1lov\DataMapper\IdentityMap;
use PDO;

abstract class DataMapper
{
    protected string $table;
    protected array $columns;
    private PDO $db;
    private IdentityMap $identityMap;

    public function __construct(DatabaseConnection $databaseConnection)
    {
        $this->db = $databaseConnection->getConnection();
        $this->identityMap = new IdentityMap();

        $this->table = $this->getTableName();
        $this->columns = $this->getColumns();
    }

    abstract protected function getTableName(): string;

    abstract protected function getColumns(): array;

    abstract protected function instantiate(array $data): ?Entity;

    public function findById(int $id): ?Entity
    {

        $entity = $this->identityMap->get($id);

        if ($entity !== null) {
            return $entity;
        }

        $query = sprintf('SELECT * FROM "%s" WHERE id = :id', $this->table);
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $entity = $this->instantiate($row);
        $this->identityMap->add($entity);

        dump($this->identityMap);

        return $entity;
    }

    public function findAll(): array
    {
        $query = sprintf('SELECT * FROM "%s"', $this->table);
        $stmt = $this->db->query($query);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $entities = [];
        foreach ($rows as $row) {
            $entity = $this->identityMap->get($row['id']);
            if ($entity === null) {
                $entity = $this->instantiate($row);
                $this->identityMap->add($entity);
            }
            $entities[] = $entity;
        }

        return $entities;
    }
}
