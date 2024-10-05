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

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectStatement = $pdo->prepare('SELECT * FROM films WHERE id = ?');
        $this->selectAllStatement = $pdo->prepare('SELECT * FROM films');
        $this->insertStatement = $pdo->prepare('INSERT INTO films (name, original_name, release_date, rating, duration, description) VALUES (?, ?, ?, ?, ?, ?)');
        $this->deleteStatement = $pdo->prepare('DELETE FROM films WHERE id = ?');
    }

    public function selectAll()
    {
        $films = [];
        $this->selectAllStatement->execute();
        $rows = $this->selectAllStatement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            $films[] = new Film(
                $row['id'],
                $row['name'],
                $row['original_name'],
                $row['release_date'],
                $row['rating'],
                $row['duration'],
                $row['description']
            );
        }
        return $films;
    }

    public function findById($id)
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);

        $result = $this->selectStatement->fetch();

        if ($result) {
            return new Film(
                $result['id'],
                $result['name'],
                $result['original_name'],
                $result['release_date'],
                $result['rating'],
                $result['duration'],
                $result['description']
            );
        } else {
            return [];
        }
    }

    public function update($id, $key, $value)
    {
        $this->updateStatement = $this->pdo->prepare('UPDATE films SET ' . $key . ' = ? WHERE id = ?');
        return $this->updateStatement->execute([$value, $id]);
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

        return new Film(
            (int)$this->pdo->lastInsertId(),
            $rawFilmData['name'],
            $rawFilmData['original_name'],
            $rawFilmData['release_date'],
            $rawFilmData['rating'],
            $rawFilmData['duration'],
            $rawFilmData['description']
        );
    }

    public function delete($id)
    {
        return $this->deleteStatement->execute([$id]);
    }
}
