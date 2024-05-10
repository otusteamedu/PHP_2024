<?php

declare(strict_types=1);

namespace AlexanderGladkov\DataPatterns\DataMapper;

use AlexanderGladkov\DataPatterns\DataMapper\EntityHelper\EntityHelpers;
use AlexanderGladkov\DataPatterns\DataMapper\EntityHelper\GenreEntityHelper;
use AlexanderGladkov\DataPatterns\Entity\Genre;
use PDO;
use PDOStatement;
use LogicException;
use Exception;
use RuntimeException;

class GenreDataMapper extends BaseDataMapper
{
    private GenreEntityHelper $genreEntityHelper;
    private PDOStatement $selectStatement;
    private PDOStatement $selectAllStatement;
    private PDOStatement $insertStatement;
    private PDOStatement $updateStatement;
    private PDOStatement $deleteStatement;
    private PDOStatement $deleteMoviesGenresStatement;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->genreEntityHelper = EntityHelpers::getGenreHelper($pdo);

        $this->selectStatement = $this->pdo->prepare(
            'SELECT * FROM genres WHERE id = :id'
        );

        $this->selectAllStatement = $this->pdo->prepare(
            'SELECT * FROM genres'
        );

        $this->insertStatement = $this->pdo->prepare(
            'INSERT INTO genres(name) VALUES(:name)'
        );

        $this->updateStatement = $this->pdo->prepare(
            'UPDATE genres SET name = :name WHERE id = :id'
        );

        $this->deleteStatement = $this->pdo->prepare(
            'DELETE FROM genres WHERE id = :id'
        );

        $this->deleteMoviesGenresStatement = $this->pdo->prepare(
            'DELETE FROM movies_genres WHERE genre_id = :genre_id'
        );
    }

    public function findById(int $id): ?Genre
    {
        $this->selectStatement->bindValue(':id', $id);
        $this->selectStatement->execute();
        $row = $this->selectStatement->fetch();
        if ($row === false) {
            return null;
        }

        return $this->genreEntityHelper->createByRow($row);
    }

    /**
     * @return Genre[]
     */
    public function findAll(): array
    {
        $this->selectAllStatement->execute();
        $rows = $this->selectAllStatement->fetchAll();
        if ($rows === false) {
            throw new RuntimeException();
        }

        $genres = [];
        foreach ($rows as $row) {
            $genres []= $this->genreEntityHelper->createByRow($row);
        }

        return $genres;
    }

    public function insert(Genre $genre): void
    {
        if ($genre->getId() !== null) {
            throw new LogicException();
        }

        $this->insertStatement->bindValue(':name', $genre->getName());
        $result = $this->insertStatement->execute();
        if ($result === false) {
            throw new RuntimeException();
        }

        $this->genreEntityHelper->setId($genre, $this->pdo->lastInsertId());
    }

    public function update(Genre $genre): void
    {
        if ($genre->getId() === null) {
            throw new LogicException();
        }

        $this->updateStatement->bindValue(':id', $genre->getId());
        $this->updateStatement->bindValue(':name', $genre->getName());
        $result = $this->updateStatement->execute();
        if ($result === false) {
            throw new RuntimeException();
        }
    }

    public function delete(int $id): void
    {
        $this->pdo->beginTransaction();
        try {
            $this->deleteMoviesGenresStatement->bindValue(':genre_id', $id);
            $result = $this->deleteMoviesGenresStatement->execute();
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
}
