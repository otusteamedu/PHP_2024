<?php

declare(strict_types=1);

namespace hw17\DataMapper;

class MoviesMapper
{
    private PDO $pdo;
    private PDOStatement $selectStatement;
    private PDOStatement $insertStatement;
    private PDOStatement $updateStatement;
    private PDOStatement $deleteStatement;

    public function __construct(
        PDO $pdo
    ) {
        $this->pdo = $pdo;
        $this->selectStatement = $pdo->prepare(
            'SELECT * FROM movies WHERE id = ?'
        );
        $this->insertStatement = $pdo->prepare(
            'INSERT INTO movies (title, description, ageLimit, language, genre, country, premiereDate, movieDuration) VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $this->updateStatement = $pdo->prepare(
            'UPDATE movies SET title = ?, description = ?, ageLimit = ?, language = ?, genre = ?, country = ?, premiereDate = ?, movieDuration = ?  WHERE id = ?'
        );
        $this->deleteStatement = $pdo->prepare(
            'DELETE FROM movies WHERE id = ?'
        );
    }

    public function findById(int $id): Movies
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);

        $result = $this->selectStatement->fetch();

        return new Movies(
            $result['id'],
            $result['title'],
            $result['description'],
            $result['ageLimit'],
            $result['language'],
            $result['genre'],
            $result['country'],
            $result['premiereDate'],
            $result['movieDuration']
        );
    }

    public function insert(array $rawMoviesData): Movies
    {
        $this->insertStatement->execute([
            $rawMoviesData['title'],
            $rawMoviesData['description'],
            $rawMoviesData['ageLimit'],
            $rawMoviesData['language'],
            $rawMoviesData['genre'],
            $rawMoviesData['country'],
            $rawMoviesData['premiereDate'],
            $rawMoviesData['movieDuration']
        ]);

        return new Movies(
            (int)$this->pdo->lastInsertId(),
            $rawMoviesData['title'],
            $rawMoviesData['description'],
            $rawMoviesData['ageLimit'],
            $rawMoviesData['language'],
            $rawMoviesData['genre'],
            $rawMoviesData['country'],
            $rawMoviesData['premiereDate'],
            $rawMoviesData['movieDuration']
        );
    }

    public function update(Movies $movies): bool
    {
        return $this->updateStatement->execute([
            $movies->getTitle(),
            $movies->getDescription(),
            $movies->getAgeLimit(),
            $movies->getLanguage(),
            $movies->getGenre(),
            $movies->getCountry(),
            $movies->getPremiereDate(),
            $movies->getMovieDuration()
        ]);
    }
}
