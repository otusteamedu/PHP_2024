<?php

namespace Ahar\Hw13;

use DomainException;
use PDO;

readonly class FilmDataMapper
{
    public function __construct(
        private MysqlConnect $connect
    )
    {
    }

    public function insert(array $data): Film
    {
        $query = $this->connect->pdo->prepare("INSERT INTO films (name, genre, description) VALUES (:name, :genre, :description)");
        $res = $query->execute([
            'name' => $data['name'],
            'genre' => $data['genre'],
            'description' => $data['description'],
        ]);

        if (empty($res)) {
            throw new \DomainException('Ошибка вставки данных');
        }

        return new Film(
            (int)$this->connect->pdo->lastInsertId(),
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
        $query = $this->connect->pdo->prepare("DELETE FROM films WHERE id = :id");
        $res = $query->execute(['id' => $id]);

        if (!$res) {
            throw new DomainException('Ошибка удаления');
        }
    }

    public function findById(int $id): ?Film
    {
        $query = $this->connect->pdo->prepare("SELECT * FROM films WHERE id = :id");
        $query->execute(['id' => $id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        return new Film((int)$result['id'], $result['name'], $result['genre'], $result['description']);
    }

    public function fetchAll(): array
    {
        $query = $this->connect->pdo->query("SELECT * FROM films");
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $films = [];
        foreach ($results as $result) {
            $films[] = new Film((int)$result['id'], $result['name'], $result['genre'], $result['description']);
        }
        return $films;
    }

}
