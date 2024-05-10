<?php

declare(strict_types=1);

namespace AlexanderGladkov\DataPatterns\DataMapper\EntityHelper;

use AlexanderGladkov\DataPatterns\Entity\Genre;
use Closure;
use PDO;
use PDOStatement;
use ReflectionProperty;
use RuntimeException;

class GenreEntityHelper extends BaseEntityHelper
{
    private PDOStatement $selectMoviesStatement;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->selectMoviesStatement = $this->pdo->prepare(
            'SELECT m.* FROM movies_genres mg INNER JOIN movies m ON mg.movie_id = m.id AND mg.genre_id = :genre_id'
        );
    }

    public function createByRow(array $row): Genre
    {
        $genreId = (int)$row['id'];
        $genre = new Genre($row['name']);
        $this->setId($genre, $genreId);
        $genre->setMoviesReference($this->createFetchMoviesClosure($genreId));
        return $genre;
    }

    public function setId(Genre $genre, mixed $id): void
    {
        $reflectionProperty = new ReflectionProperty(Genre::class, 'id');
        $reflectionProperty->setValue($genre, $id);
    }

    public function setMovies(Genre $genre, ?array $movies): void
    {
        $reflectionProperty = new ReflectionProperty(Genre::class, 'movies');
        $reflectionProperty->setValue($genre, $movies);
    }

    private function createFetchMoviesClosure(int $genreId): Closure
    {
        $movieEntityHelper = EntityHelpers::getMovieHelper($this->pdo);
        return function() use($genreId, $movieEntityHelper) : array {
            $this->selectMoviesStatement->bindValue(':genre_id', $genreId);
            $this->selectMoviesStatement->execute();
            $rows = $this->selectMoviesStatement->fetchAll();
            if ($rows === false) {
                throw new RuntimeException();
            }

            $movies = [];
            foreach ($rows as $row) {
                $movies[] = $movieEntityHelper->createByRow($row);
            }

            return $movies;
        };
    }
}
