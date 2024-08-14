<?php

declare(strict_types=1);

namespace Viking311\DbPattern\Model;

use PDO;

class MovieFinder
{
    /**
     * @param PDO $pdo
     */
    public function __construct(private PDO $pdo)
    {
    }

    /**
     * @param integer $id
     * @return Movie|null
     */
    public function getMovieById(int $id): ?Movie
    {
        $sth = $this->pdo->prepare('SELECT * FROM movies WHERE id=:id');
        $sth->execute([':id' => $id]);
        $res = $sth->fetchAll(PDO::FETCH_ASSOC);

        $movie = null;
        if (!empty($res)) {
            $movie = new Movie($this->pdo);
            $movie->fromArray($res[0]);
        }

        return $movie;
    }

    /**
     * @return array<int, Movie>
     */
    public function getMovieList(): array
    {
        $res = $this->pdo->query('SELECT * FROM movies WHERE deleted_at IS NULL');

        $movies = [];
        foreach ($res->fetchAll(PDO::FETCH_ASSOC) as $movieData) {
            $movie = new Movie($this->pdo);
            $movie->fromArray($movieData);
            $movies[] = $movie;
        }

        return $movies;
    }
}
