<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\RequestProcessEntity;
use App\Provider\DatabaseProviderInterface;
use PDO;

class RequestProcessRepository implements RequestProcessRepositoryInterface
{
    private PDO $connection;
    public function __construct(DatabaseProviderInterface $databaseProvider)
    {
        $this->connection = $databaseProvider->getConnection();
    }

    public function findById(int $id): ?RequestProcessEntity
    {
        $query = $this->connection->prepare('SELECT * FROM request_process WHERE id = :id');
        $query->execute(['id' => $id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return null;
        }
        return new RequestProcessEntity($result['id'], $result['uuid']);
    }

    public function add(): RequestProcessEntity
    {
        $this->connection->query('INSERT INTO request_process (uuid) VALUES (null)');
        $id = (int) $this->connection->lastInsertId();
        return new RequestProcessEntity($id, null);
    }

    public function update(int $id, string $uuid): void
    {
        $query = $this->connection->prepare('UPDATE request_process SET uuid = :uuid WHERE id = :id');
        $query->execute(['id' => $id, 'uuid' => $uuid]);
    }
}
