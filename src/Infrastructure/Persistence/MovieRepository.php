<?php

namespace Infrastructure\Persistence;

use Domain\Entities\Movie;
use Domain\Repositories\MovieRepositoryInterface;
use Infrastructure\Database\DatabaseConnection;
use PDO;

class MovieRepository implements MovieRepositoryInterface
{
    private PDO $connection;
    public const string TABLE = 'movies';

    public function __construct()
    {
        $this->connection = DatabaseConnection::getInstance()->getConnection();
    }

    public function findAll(): array
    {
        $stmt = $this->connection->query("SELECT * FROM " . self::TABLE);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Movie::class);
    }

    public function findById(int $id): ?Movie
    {
        $stmt = $this->connection->prepare("SELECT * FROM " . self::TABLE . " WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchObject(Movie::class) ?: null;
    }

    public function save(Movie $entity): false|string
    {
        if ($entity->id) {
            $stmt = $this->connection->prepare("UPDATE " . self::TABLE . " SET title = :title, genre = :genre WHERE id = :id");
            $stmt->execute([
                'id' => $entity->id,
                'title' => $entity->title,
                'genre' => $entity->genre,
            ]);
        } else {
            $stmt = $this->connection->prepare("INSERT INTO " . self::TABLE . " (title, genre) VALUES (:title, :genre)");
            $stmt->execute([
                'title' => $entity->title,
                'genre' => $entity->genre,
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
