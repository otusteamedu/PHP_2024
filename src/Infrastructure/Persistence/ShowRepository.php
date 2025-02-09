<?php

namespace Infrastructure\Persistence;

use Domain\Entities\Show;
use Domain\Repositories\ShowRepositoryInterface;
use Infrastructure\Database\DatabaseConnection;
use PDO;

class ShowRepository implements ShowRepositoryInterface
{
    private PDO $connection;
    public const TABLE = 'shows';

    public function __construct()
    {
        $this->connection = DatabaseConnection::getInstance()->getConnection();
    }

    public function findAll(): array
    {
        $stmt = $this->connection->query("SELECT * FROM " . self::TABLE);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Show::class);
    }

    public function findById(int $id): ?Show
    {
        $stmt = $this->connection->prepare("SELECT * FROM " . self::TABLE . " WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchObject(Show::class) ?: null;
    }

    public function save(Show $entity): void
    {
        if ($entity->id) {
            $stmt = $this->connection->prepare("UPDATE " . self::TABLE . " SET movie_id = :movie_id, theatre_id = :theatre_id, start = :start WHERE id = :id");
            $stmt->execute([
                'id' => $entity->id,
                'movie_id' => $entity->movie_id,
                'theatre_id' => $entity->theatre_id,
                'start' => $entity->start,
            ]);
        } else {
            $stmt = $this->connection->prepare("INSERT INTO " . self::TABLE . " (movie_id, theatre_id, start) VALUES (:movie_id, :theatre_id, :start)");
            $stmt->execute([
                'movie_id' => $entity->movie_id,
                'theatre_id' => $entity->theatre_id,
                'start' => $entity->start,
            ]);
        }
    }

    public function delete(int $id): void
    {
        $stmt = $this->connection->prepare("DELETE FROM " . self::TABLE . " WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
