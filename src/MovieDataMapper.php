<?php

declare(strict_types=1);

namespace Afilipov\Hw13;

use Closure;
use PDO;
use RuntimeException;

readonly class MovieDataMapper
{
    public function __construct(private DbConnection $dbConnection)
    {
    }

    public function findById(int $id): ?Movie
    {
        $query = $this->dbConnection->pdo->prepare("SELECT * FROM movies WHERE id = :id");
        $query->execute(['id' => $id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        $movie = new Movie((int)$result['id'], $result['title'], $result['director'], (int)$result['release_year']);
        $movie->setReviewReference($this->fetchReviewsForMovie($id));

        return $movie;
    }


    public function insert(array $rawData): Movie
    {
        $query = $this->dbConnection->pdo->prepare("INSERT INTO movies (title, director, release_year) VALUES (:title, :director, :release_year)");
        $res = $query->execute([
            'title' => $rawData['title'],
            'director' => $rawData['director'],
            'release_year' => $rawData['release_year']
        ]);

        if (empty($res)) {
            throw new RuntimeException('Insert data error');
        }

        return new Movie(
            (int)$this->dbConnection->pdo->lastInsertId(),
            $rawData['title'],
            $rawData['director'],
            (int)$rawData['release_year'],
        );
    }

    public function update(Movie $movie): void
    {
        $query = $this->dbConnection->pdo->prepare("UPDATE movies SET title = :title, director = :director, release_year = :release_year WHERE id = :id");
        $res = $query->execute([
            'id' => $movie->getId(),
            'title' => $movie->getTitle(),
            'director' => $movie->getDirector(),
            'release_year' => $movie->getReleaseYear()
        ]);

        if (!$res) {
            throw new RuntimeException('Update data error');
        }
    }

    public function delete(int $id): void
    {
        $query = $this->dbConnection->pdo->prepare("DELETE FROM movies WHERE id = :id");
        $res = $query->execute(['id' => $id]);

        if (!$res) {
            throw new RuntimeException('Delete data error');
        }
    }

    /**
     * @return array<Movie>
     */
    public function fetchAll(): array
    {
        $query = $this->dbConnection->pdo->query("SELECT * FROM movies");
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $movies = [];
        foreach ($results as $result) {
            $movie = new Movie((int)$result['id'], $result['title'], $result['director'], (int)$result['release_year']);
            $movie->setReviewReference($this->fetchReviewsForMovie($movie->getId()));
            $movies[] = $movie;
        }

        return $movies;
    }

    private function fetchReviewsForMovie(int $id): Closure
    {
        return function () use ($id) {
            $query = $this->dbConnection->pdo->prepare('SELECT * FROM reviews WHERE movie_id = :id');
            $query->execute(['id' => $id]);
            $results = $query->fetchAll(PDO::FETCH_ASSOC);

            $reviews = [];
            foreach ($results as $result) {
                $review = new Review($result['text']);
                $review->setId((int)$result['id']);
                $reviews[] = $review;
            }

            return $reviews;
        };
    }
}
