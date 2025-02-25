<?php

namespace Infrastructure\Persistence;

use Domain\Entities\Theatre;
use Domain\Repositories\TheatreRepositoryInterface;
use Infrastructure\Database\DatabaseConnection;
use PDO;

class TheatreRepository implements TheatreRepositoryInterface
{
    private PDO $connection;
    public const string TABLE = 'theatres';

    public function __construct()
    {
        $this->connection = DatabaseConnection::getInstance()->getConnection();
    }

    public function findAll(): array
    {
        $stmt = $this->connection->query("SELECT * FROM " . self::TABLE);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Theatre::class);
    }

    public function findById(int $id): ?Theatre
    {
        $stmt = $this->connection->prepare("SELECT * FROM " . self::TABLE . " WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchObject(Theatre::class) ?: null;
    }

    public function save(Theatre $entity): string|false
    {
        if ($entity->id) {
            $stmt = $this->connection->prepare("UPDATE " . self::TABLE . " SET title = :title, location = :location, capacity = :capacity WHERE id = :id");
            $stmt->execute([
                'id' => $entity->id,
                'title' => $entity->title,
                'location' => $entity->location,
                'capacity' => $entity->capacity
            ]);
        } else {
            $stmt = $this->connection->prepare("INSERT INTO " . self::TABLE . " (title, location, capacity) VALUES (:title, :location, :capacity)");
            $stmt->execute([
                'title' => $entity->title,
                'location' => $entity->location,
                'capacity' => $entity->capacity
            ]);
        }

        return $this->connection->lastInsertId();
    }

    public function delete(int $id): void
    {
        $stmt = $this->connection->prepare("DELETE FROM " . self::TABLE . " WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
