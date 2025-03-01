<?php

namespace App\DataMapper;

use App\Model\Country;
use PDO;

class CountryMapper
{
    private string $table = 'countries';

    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getByFilm(int $filmId): array
    {
        $sql = "SELECT c.id as id, c.name as name FROM {$this->table} c 
                join country_film as cf on c.id = cf.country_id 
                WHERE film_id = :film_id";

        $result = $this->connection->prepare($sql);

        $result->bindParam(':film_id', $filmId, PDO::PARAM_INT);

        $result->execute();

        return $result->fetchALL(PDO::FETCH_CLASS, Country::class);

    }
}