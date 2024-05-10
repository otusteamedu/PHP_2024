<?php

declare(strict_types=1);

namespace AlexanderGladkov\DataPatterns\DataMapper;

use AlexanderGladkov\DataPatterns\DataMapper\EntityHelper\EntityHelpers;
use AlexanderGladkov\DataPatterns\DataMapper\EntityHelper\MovieEntityHelper;
use AlexanderGladkov\DataPatterns\Entity\Movie;
use AlexanderGladkov\DataPatterns\Entity\Genre;
use PDO;
use PDOStatement;
use Exception;
use LogicException;
use RuntimeException;

class MovieDataMapper extends BaseDataMapper
{
    private MovieEntityHelper $movieEntityHelper;

    private PDOStatement $selectStatement;
    private PDOStatement $selectAllStatement;
    private PDOStatement $insertStatement;
    private PDOStatement $updateStatement;
    private PDOStatement $deleteStatement;
    private PDOStatement $deleteMovieGenresStatement;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->movieEntityHelper = EntityHelpers::getMovieHelper($pdo);

        $this->selectStatement = $this->pdo->prepare(
            'SELECT * FROM movies WHERE id = :id'
        );

        $this->selectAllStatement = $this->pdo->prepare(
            'SELECT * FROM movies'
        );

        $this->insertStatement = $this->pdo->prepare(
            'INSERT INTO movies(title, release_date, duration, description) ' .
            'VALUES(:title, :release_date, :duration, :description)'
        );

        $this->updateStatement = $this->pdo->prepare(
            'UPDATE movies SET ' .
                'title = :title, release_date = :release_date, duration = :duration, description = :description ' .
            'WHERE id = :id'
        );

        $this->deleteStatement = $this->pdo->prepare(
            'DELETE FROM movies WHERE id = :id'
        );

        $this->deleteMovieGenresStatement = $this->pdo->prepare(
            'DELETE FROM movies_genres WHERE movie_id = :movie_id'
        );
    }

    public function findById(int $id): ?Movie
    {
        $this->selectStatement->bindValue(':id', $id);
        $this->selectStatement->execute();
        $row = $this->selectStatement->fetch();
        if ($row === false) {
            return null;
        }

        return $this->movieEntityHelper->createByRow($row);
    }

    /**
     * @return Movie[]
     */
    public function findAll(): array
    {
        $this->selectAllStatement->execute();
        $rows = $this->selectAllStatement->fetchAll();
        if ($rows === false) {
            throw new RuntimeException();
        }

        $movies = [];
        foreach ($rows as $row) {
            $movies[] = $this->movieEntityHelper->createByRow($row);
        }

        return $movies;
    }

    public function insert(Movie $movie): void
    {
        if ($movie->getId() !== null) {
            throw new LogicException();
        }

        $this->insertStatement->bindValue(':title', $movie->getTitle());
        $this->insertStatement->bindValue(':release_date', $movie->getReleaseDate()->format('Y-m-d'));
        $this->insertStatement->bindValue(':duration', $movie->getDuration());
        $this->insertStatement->bindValue(':description', $movie->getDescription());
        $result = $this->insertStatement->execute();
        if ($result === false) {
            throw new RuntimeException();
        }

        $this->movieEntityHelper->setId($movie, $this->pdo->lastInsertId());
    }

    public function update(Movie $movie): void
    {
        if ($movie->getId() === null) {
            throw new LogicException();
        }

        $this->updateStatement->bindValue(':id', $movie->getId());
        $this->updateStatement->bindValue(':title', $movie->getTitle());
        $this->updateStatement->bindValue(':release_date', $movie->getReleaseDate()->format('Y-m-d'));
        $this->updateStatement->bindValue(':duration', $movie->getDuration());
        $this->updateStatement->bindValue(':description', $movie->getDescription());
        $result = $this->updateStatement->execute();
        if ($result === false) {
            throw new RuntimeException();
        }
    }

    public function delete(int $id): void
    {
        $this->pdo->beginTransaction();
        try {
            $this->deleteMovieGenresStatement->bindValue(':movie_id', $id);
            $result = $this->deleteMovieGenresStatement->execute();
            if ($result === false) {
                throw new RuntimeException();
            }

            $this->deleteStatement->bindValue(':id', $id);
            $result = $this->deleteStatement->execute();
            if ($result === false) {
                throw new RuntimeException();
            }

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * @param Movie $movie
     * @param Genre[] $genres
     * @return void
     */
    public function updateGenres(Movie $movie, array $genres): void
    {
        if ($movie->getId() === null) {
            throw new LogicException();
        }

        foreach ($genres as $genre) {
            if ($genre->getId() === null) {
                throw new LogicException();
            }
        }

        $this->pdo->beginTransaction();
        try {
            $movieId = $movie->getId();
            $this->deleteMovieGenresStatement->bindValue(':movie_id', $movieId);
            $result = $this->deleteMovieGenresStatement->execute();
            if ($result === false) {
                throw new RuntimeException();
            }

            if (count($genres) > 0) {
                $this->insertMovieGenres($movieId, $genres);
            }

            $this->movieEntityHelper->setGenres($movie, $genres);
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new RuntimeException($e->getMessage());
        }
    }

    private function insertMovieGenres(int $movieId, array $genres): void
    {
        $valuesSql = [];
        foreach ($genres as $genre) {
            $valuesSql[] = "($movieId, {$genre->getId()})";
        }

        $valuesSql = implode(', ', $valuesSql);
        $sql = 'INSERT INTO movies_genres(movie_id, genre_id) VALUES' .  $valuesSql;
        $result = $this->pdo->prepare($sql)->execute();
        if ($result === false) {
            throw new RuntimeException();
        }
    }
}
