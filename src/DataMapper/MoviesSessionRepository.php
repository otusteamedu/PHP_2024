<?php

declare(strict_types=1);

namespace hw17\DataMapper;

use Pdo;
use PDOStatement;
use Closure;

class MoviesSessionRepository
{
    public function __construct(
        PDO $pdo
    ) {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        /** @var PDOStatement $query */
        $query = $this->pdo->prepare(
            'SELECT * FROM movies_sessions'
        );
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $movies = [];
        foreach ($result as $item) {
            $movieSession = new MoviesSessions(
                $item['id'],
                $item['hallsId'],
                $item['movieId'],
                $item['startTime'],
                $item['endTime']
            );
            $movieSession->setMovieReference($this->getMovie($movieSession->getMovieId()));
            $movieSession->setHallReference($this->getHall($movieSession->getHallId()));
            $movies[] = $movieSession;
        }

        return $movies;
    }

    private function getHall(int $hallId)
    {
        return function () use ($hallId) {
            /** @var PDOStatement $query */
            $query = $this->pdo->prepare(
                'SELECT * FROM halls WHERE id = ?'
            );

            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute([$hallId]);

            $result = $query->fetch();

            return new Halls(
                $result['id'],
                $result['hallName'],
                $result['numberOfSeats'],
                $result['isPremium']
            );
        };
    }

    /**
     * @param int $movieId
     * @return \Closure
     */
    private function getMovie(int $movieId): Closure
    {
        return function () use ($movieId) {
            /** @var PDOStatement $query */
            $query = $this->pdo->prepare(
                'SELECT * FROM movies WHERE id = ?'
            );

            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute([$movieId]);

            $result = $query->fetch();

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
        };
    }
}
