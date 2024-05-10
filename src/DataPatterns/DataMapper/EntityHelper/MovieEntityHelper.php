<?php

declare(strict_types=1);

namespace AlexanderGladkov\DataPatterns\DataMapper\EntityHelper;

use AlexanderGladkov\DataPatterns\Entity\Movie;
use DateTime;
use DateTimeZone;
use PDO;
use PDOStatement;
use ReflectionProperty;
use RuntimeException;
use Closure;

class MovieEntityHelper extends BaseEntityHelper
{
    private PDOStatement $selectGenresStatement;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);

        $this->selectGenresStatement = $this->pdo->prepare(
            'SELECT g.* FROM movies_genres mg INNER JOIN genres g ON mg.genre_id = g.id AND mg.movie_id = :movie_id'
        );
    }

    public function createByRow(array $row): Movie
    {
        $movieId = (int)$row['id'];
        $releaseDate = DateTime::createFromFormat(
            'Y-m-d H:i:s',
            $row['release_date'] . ' 00:00:00',
            new DateTimeZone('UTC')
        );

        $movie = new Movie(
            $row['title'],
            $releaseDate,
            $row['duration'],
            $row['description']
        );

        $this->setId($movie, $movieId);
        $movie->setGenresReference($this->createFetchGenresClosure($movieId));
        return $movie;
    }

    public function setId(Movie $movie, mixed $id): void
    {
        $reflectionProperty = new ReflectionProperty(Movie::class, 'id');
        $reflectionProperty->setValue($movie, $id);
    }

    public function setGenres(Movie $movie, ?array $genres): void
    {
        $reflectionProperty = new ReflectionProperty(Movie::class, 'genres');
        $reflectionProperty->setValue($movie, $genres);
    }

    private function createFetchGenresClosure(int $movieId): Closure
    {
        $genreEntityHelper = EntityHelpers::getGenreHelper($this->pdo);
        return function () use ($movieId, $genreEntityHelper): array {
            $this->selectGenresStatement->bindValue(':movie_id', $movieId);
            $this->selectGenresStatement->execute();
            $rows = $this->selectGenresStatement->fetchAll();
            if ($rows === false) {
                throw new RuntimeException();
            }


            $genres = [];
            foreach ($rows as $row) {
                $genres[] = $genreEntityHelper->createByRow($row);
            }

            return $genres;
        };
    }
}
