<?php

namespace AnatolyShilyaev\Hw11;

use PDO;

class MovieMapper
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param $id
     * @return Movie|null
     */
    public function find($id): ?Movie
    {

        $stmt = $this->pdo->prepare('SELECT * FROM movies WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            $movie = new Movie(
                $data['id'] ?? null,
                $data['name'] ?? null,
            );
            return $movie;
        }

        return null;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function findAll(int $limit = 30, int $offset = 0): array
    {
        print_r($offset + $limit);
        $stmt = $this->pdo->prepare("SELECT * FROM movies WHERE id > ? ORDER BY id LIMIT ?");
        $stmt->execute([$offset, $limit,]);
        $movies = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $movie = new Movie(
                $data['id'] ?? null,
                $data['name'] ?? null,
            );
            $movies[] = $movie;
        }

        return $movies;
    }

    /**
     * @param Movie $movie
     * @return int
     */
    public function insert(Movie $movie): int
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO movies (name) 
            VALUES (:name)
        ');

        $stmt->execute([
            'name' => $movie->getName(),
        ]);

        $id = (int) $this->pdo->lastInsertId();
        $movie->setId($id);

        return $id;
    }

    /**
     * @param Movie $movie
     * @param string $newName
     * @return bool
     */
    public function update(Movie $movie, string $newName): bool
    {
        $stmt = $this->pdo->prepare('UPDATE movies SET name = :name WHERE id = :id');

        $result = $stmt->execute([
            'name' => $newName,
            'id' => $movie->getId(),
        ]);

        return $result;
    }

    /**
     * @param $id
     * @return void
     */
    public function delete($id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM movies WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
