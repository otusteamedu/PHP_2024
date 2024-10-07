<?php

declare(strict_types=1);

namespace Evgenyart\Hw13;

use Exception;
use PDO;
use PDOStatement;

class FilmMapper
{
    private PDO $pdo;

    private PDOStatement $selectStatement;

    private PDOStatement $selectAllStatement;

    private PDOStatement $insertStatement;

    private PDOStatement $updateStatement;

    private PDOStatement $deleteStatement;

    private $identityMap = [];

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectStatement = $pdo->prepare('SELECT * FROM films WHERE id = ?');
        $this->selectAllStatement = $pdo->prepare('SELECT * FROM films LIMIT ? OFFSET ?');
        $this->insertStatement = $pdo->prepare('INSERT INTO films (name, original_name, release_date, rating, duration, description) VALUES (?, ?, ?, ?, ?, ?)');
        $this->deleteStatement = $pdo->prepare('DELETE FROM films WHERE id = ?');
        $this->updateStatement = $pdo->prepare('UPDATE films SET name = ?, original_name = ?, release_date = ?, rating = ?, duration = ?, description = ?  WHERE id = ?');
    }

    public function selectAll($limit = 50, $offset = 0)
    {
        $films = [];
        $this->selectAllStatement->execute([$limit, $offset]);
        $rows = $this->selectAllStatement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            $film = new Film(
                $row['id'],
                $row['name'],
                $row['original_name'],
                $row['release_date'],
                $row['rating'],
                $row['duration'],
                $row['description']
            );
            $this->identityMap[$row['id']] = $film;
            $films[] = $film;
        }
        return $films;
    }

    public function findById($id)
    {
        if (isset($this->identityMap[$id])) {
            return $this->identityMap[$id];
        }

        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);

        $result = $this->selectStatement->fetch();

        if ($result) {
            $film = new Film(
                $result['id'],
                $result['name'],
                $result['original_name'],
                $result['release_date'],
                $result['rating'],
                $result['duration'],
                $result['description']
            );
            $this->identityMap[$id] = $film;
            return $film;
        } else {
            return [];
        }
    }

    public function update($objectFilm)
    {
        $id = $objectFilm->getId();

        $film = $this->updateStatement->execute([
            $objectFilm->getName(),
            $objectFilm->getOriginalName(),
            $objectFilm->getReleaseDate(),
            $objectFilm->getRating(),
            $objectFilm->getDuration(),
            $objectFilm->getDescription(),
            $id
        ]);

        $this->identityMap[$id] = $objectFilm;

        return $film;
    }

    public function insert(array $rawFilmData)
    {
        $this->insertStatement->execute([
            $rawFilmData['name'],
            $rawFilmData['original_name'],
            $rawFilmData['release_date'],
            $rawFilmData['rating'],
            $rawFilmData['duration'],
            $rawFilmData['description']
        ]);

        $id = (int)$this->pdo->lastInsertId();

        $film = new Film(
            $id,
            $rawFilmData['name'],
            $rawFilmData['original_name'],
            $rawFilmData['release_date'],
            $rawFilmData['rating'],
            $rawFilmData['duration'],
            $rawFilmData['description']
        );

        $this->identityMap[$id] = $film;
        
        return $film;
    }

    public function delete($id)
    {
        $res = $this->deleteStatement->execute([$id]);
        if (isset($this->identityMap[$id])) {
            unset($this->identityMap[$id]);
        }
        
        return $res;
    }
}
