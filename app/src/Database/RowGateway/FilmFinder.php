<?php

declare(strict_types=1);

namespace VictoriaBabikova\DbWorkerApp\Database\RowGateway;

use PDO;
use PDOStatement;

class FilmFinder
{
    private PDO $pdo;
    private PDOStatement $selectStatement;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStatement = $this->pdo->prepare(
            'SELECT * FROM public."Films" WHERE id = ?'
        );
    }
    public function findOneById(int $id): Film
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);
        $result = $this->selectStatement->fetch();

        return $this->creatorFilm($result);
    }

    public function getAllFilms(): array
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement = $this->pdo->prepare(
            'SELECT * FROM public."Films"'
        );
        $this->selectStatement->execute();
        $resultArray =  $this->selectStatement->fetchAll();

        $films = [];

        foreach ($resultArray as $item) {
            $films[] = $this->creatorFilm($item);
        }
        return $films;
    }

    private function creatorFilm($result): Film
    {
        $film = new Film($this->pdo);
        $film
            ->setId($result['id'])
            ->setName($result['name'])
            ->setDuration($result['duration'])
            ->setManufacturer($result['manufacturer'])
            ->setDirector($result['director'])
            ->setDescription($result['description'])
            ->setRentalCompany($result['rental_company'])
            ->setAgeLimits($result['age_limits'])
            ->setActors($result['actors'])
            ->setFilmLinks($result['film_links']);

        return $film;
    }
}
