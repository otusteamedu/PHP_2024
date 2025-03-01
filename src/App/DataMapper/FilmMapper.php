<?php

namespace App\DataMapper;

use App\Model\Film;
use PDO;

class FilmMapper
{
    private string $table = 'films';

    private PDO $connection;
    private CountryMapper $countryMapper;

    private $identityMap = [];

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
        $this->countryMapper = new CountryMapper($connection);
    }

    public function save(Film $film): bool
    {
        if (empty($film->id)) {
            $sql = "INSERT INTO {$this->table} (name, year) VALUES (:name, :year)";
        } else {
            $sql = "UPDATE {$this->table} SET name = :name, year = : year WHERE id = :id";
        }

        $result = $this->connection->prepare($sql);
        $result->bindParam(':id', $film->id, PDO::PARAM_INT);
        $result->bindParam(':name', $film->name);
        $result->bindParam(':yaer', $film->year, PDO::PARAM_INT);

        if ($result->execute()) {
            return $result->fetch(PDO::FETCH_ASSOC);
        }

        return false;
    }

    public function find(int $id): ?Film
    {
        if (isset($this->identityMap[$id])) {
            return $this->identityMap[$id];
        }

        $sql = "SELECT * FROM {$this->table} WHERE id = :id";

        $result = $this->connection->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();

        return $this->fetchObject($result);
    }

    public function all(): array
    {
        $sql = "SELECT * FROM {$this->table}";

        $result = $this->connection->prepare($sql);
        $result->execute();

        return $this->fetchAll($result);

    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";

        $result = $this->connection->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        if ($result->execute()) {
            return $result->fetch(PDO::FETCH_ASSOC);
        }

        return false;
    }

    private function fetchAll(\PDOStatement $result)
    {
        $films = $result->fetchALL(PDO::FETCH_CLASS, Film::class);

        foreach ($films as $key => $film) {
            $films[$key] = $this->prepareFilm($film);
        }

        return $films;
    }

    private function fetchObject(\PDOStatement $result)
    {
        $film = $result->fetchObject(Film::class);

        if ($film === FALSE) {
            return null;
        }

        return $this->prepareFilm($film);
    }

    private function prepareFilm(Film $film)
    {
        $this->setRelationsCallback($film);

        $this->identityMap[$film->id] = $film;

        return $film;
    }

    private function setRelationsCallback(Film $film)
    {
        $countryMapper = $this->countryMapper;
        $film->setCountries(
            function () use ($film, $countryMapper) {
                return $countryMapper->getByFilm($film->id);
            }
        );
    }
}