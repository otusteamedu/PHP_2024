<?php

declare(strict_types=1);

namespace Otus\DbPattern\DbMapper;

use Otus\DbPattern\Models\Movie;
use PDO;

class MovieMapper
{
    private PDO $pdo;
    private array $identityMap = [];

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
        if (isset($this->identityMap[$id])) {
            return $this->identityMap[$id];
        }

        $stmt = $this->pdo->prepare('SELECT * FROM movies WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            $movie = new Movie(
                $data['id'] ?? null,
                $data['title'] ?? null,
                $data['start_date'] ?? null,
                $data['end_date'] ?? null,
                $data['rental_cost'] ?? null
            );
            $this->identityMap[$id] = $movie;
            return $movie;
        }

        return null;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function findAll(int $limit = 100, int $offset = 0): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM movies LIMIT ? OFFSET ?');
        $stmt->execute([$limit, $offset]);
        $movies = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $data['id'];

            if (isset($this->identityMap[$id])) {
                $movies[] = $this->identityMap[$id];
            } else {
                $movie = new Movie(
                    $data['id'] ?? null,
                    $data['title'] ?? null,
                    $data['start_date'] ?? null,
                    $data['end_date'] ?? null,
                    $data['rental_cost'] ?? null
                );

                $this->identityMap[$id] = $movie;
                $movies[] = $movie;
            }
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
            INSERT INTO movies (title, start_date, end_date, rental_cost) 
            VALUES (:title, :start_date, :end_date, :rental_cost)
        ');

        $stmt->execute([
            'title' => $movie->getTitle(),
            'start_date' => $movie->getStartDate(),
            'end_date' => $movie->getEndDate(),
            'rental_cost' => $movie->getRentalCost()
        ]);

        $id = (int) $this->pdo->lastInsertId();
        $movie->setId($id);
        $this->identityMap[$id] = $movie;

        return $id;
    }

    /**
     * @param Movie $movie
     * @return void
     */
    public function update(Movie $movie): void
    {
        $dirtyFields = $movie->getDirtyFields();
        if (empty($dirtyFields)) {
            return;
        }

        $setPart = [];
        foreach ($dirtyFields as $field => $value) {
            $setPart[] = "$field = :$field";
        }

        $sql = 'UPDATE movies SET ' . implode(', ', $setPart) . ' WHERE id = :id';
        $params = array_merge($dirtyFields, ['id' => $movie->getId()]);

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        $this->identityMap[$movie->getId()] = $movie;
        $movie->clearDirtyFields();
    }

    /**
     * @param $id
     * @return void
     */
    public function delete($id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM movies WHERE id = :id');
        $stmt->execute(['id' => $id]);
        unset($this->identityMap[$id]);
    }
}
