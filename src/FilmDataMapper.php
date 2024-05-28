<?php

namespace Ahar\Hw13;

use DomainException;
use PDO;
use PDOStatement;

readonly class FilmDataMapper
{
    private PDO $pdo;

    private PDOStatement $insertStatement;
    private PDOStatement $findByIdStatement;
    private PDOStatement $deleteStatement;
    private PDOStatement $selectAllStatement;

    public function __construct(
        private MysqlConnect $connect
    )
    {
        $this->pdo = $this->connect->pdo;
        $this->insertStatement = $this->pdo->prepare("INSERT INTO films (name, genre, description) VALUES (:name, :genre, :description)");
        $this->deleteStatement = $this->pdo->prepare("DELETE FROM films WHERE id = :id");
        $this->findByIdStatement = $this->pdo->prepare("SELECT * FROM films WHERE id = :id");
        $this->selectAllStatement = $this->pdo->prepare("SELECT * FROM films");
    }

    public function insert(array $data): Film
    {
        $res = $this->insertStatement->execute([
            'name' => $data['name'],
            'genre' => $data['genre'],
            'description' => $data['description'],
        ]);

        if (empty($res)) {
            throw new \DomainException('Ошибка вставки данных');
        }

        return new Film(
            (int)$this->pdo->lastInsertId(),
            $data['name'],
            $data['genre'],
            $data['description'],
        );
    }

    public function update(Film $film): void
    {
        $existFilm = $this->findById($film->id);
        if ($existFilm === null) {
            throw new DomainException('Ошибка обновления');
        }

        $updateData = [];
        $params = ['id' => $film->id];

        foreach (['name', 'genre', 'description'] as $value) {
            if ($existFilm->$value !== $film->$value) {
                $updateData[] = "{$value} = :$value";
                $params[$value] = $film->$value;
            }
        }

        if (empty($updateData)) {
            return;
        }

        $query = $this->connect->pdo->prepare("UPDATE films SET " . implode(', ', $updateData) . " WHERE id = :id");
        $res = $query->execute($params);

        if (!$res) {
            throw new DomainException('Ошибка обновления');
        }
    }

    public function delete(int $id): void
    {
        $res = $this->deleteStatement->execute(['id' => $id]);

        if (!$res) {
            throw new DomainException('Ошибка удаления');
        }
    }

    public function findById(int $id): ?Film
    {
        $this->findByIdStatement->execute(['id' => $id]);
        $result = $this->findByIdStatement->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        return new Film((int)$result['id'], $result['name'], $result['genre'], $result['description']);
    }

    public function fetchAll(): array
    {
        $results = $this->selectAllStatement->fetchAll(PDO::FETCH_ASSOC);

        $films = [];
        foreach ($results as $result) {
            $films[] = new Film((int)$result['id'], $result['name'], $result['genre'], $result['description']);
        }
        return $films;
    }

}
