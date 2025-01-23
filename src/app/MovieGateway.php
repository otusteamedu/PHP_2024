<?php

declare(strict_types=1);

namespace App;

use App\DB\DbConnection;

class MovieGateway extends AbstractGateway
{
    protected static string $table = 'movies';
    protected static string $directorsTable = 'movie_directors';

    public function findById($id)
    {
        if (isset($this->identityMap[$id])) {
            return $this->identityMap[$id];
        }

        $stmt = $this->dbConnection->prepare("SELECT * FROM " . static::$table . " WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row) {
            $director = (new MovieDirectorGateway())->findById($row['movie_director_id']);
            $movie = new Movie($row['id'], $row['title'], $row['orig_title'], $row['genre'], $row['year'], $row['duration'], $row['rating'], $row['movie_director_id'], $director);
            $this->identityMap[$id] = $movie;
            return $movie->toArray();
        }

        return null;
    }

    public function findAll(): array
    {
        $stmt = $this->dbConnection->query("SELECT * FROM " . static::$table . " ORDER BY id DESC");
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $results = [];
        foreach ($rows as $row) {
            $results[] = (new Movie(...$row))->toArray();
        }

        return $results;
    }

    public function insert(Movie $movie): bool
    {
        $stmt = $this->dbConnection->prepare("INSERT INTO " . static::$table . " (title, orig_title, genre, year, duration, rating, movie_director_id) VALUES (:title, :orig_title, :genre, :year,
:duration, :rating, :movie_director_id)");
        return $stmt->execute([
            ':title' => $movie->getTitle(),
            ':orig_title' => $movie->getOrigTitle(),
            ':genre' => $movie->getGenre(),
            ':year' => $movie->getYear(),
            ':duration' => $movie->getDuration(),
            ':rating' => $movie->getRating(),
            ':movie_director_id' => $movie->getDirectorId(),
        ]);
    }

    public function update(Movie $movie): bool
    {
        $stmt = $this->dbConnection->prepare("UPDATE " . static::$table . " SET title = :title, orig_title = :orig_title, genre = :genre, year = :year, duration = :duration, rating = :rating,
movie_director_id = :movie_director_id WHERE id = :id");
        return $stmt->execute([
            ':id' => $movie->getId(),
            ':title' => $movie->getTitle(),
            ':orig_title' => $movie->getOrigTitle(),
            ':genre' => $movie->getGenre(),
            ':year' => $movie->getYear(),
            ':duration' => $movie->getDuration(),
            ':rating' => $movie->getRating(),
            ':movie_director_id' => $movie->getDirectorId(),
        ]);
    }
}
