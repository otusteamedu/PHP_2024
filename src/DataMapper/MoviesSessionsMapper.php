<?php

declare(strict_types=1);

namespace hw17\DataMapper;

class MoviesSessionsMapper
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
            'SELECT * FROM movies_sessions WHERE id = ?'
        );
        $this->insertStatement = $pdo->prepare(
            'INSERT INTO movies_sessions (hallsId, movieId, startTime, endTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $this->updateStatement = $pdo->prepare(
            'UPDATE movies_sessions SET hallsId = ?, movieId = ?, startTime = ?, endTime = ? WHERE id = ?'
        );
        $this->deleteStatement = $pdo->prepare(
            'DELETE FROM movies_sessions WHERE id = ?'
        );
    }

    public function findById(int $id): MoviesSessions
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);

        $result = $this->selectStatement->fetch();

        return new MoviesSessions(
            $result['id'],
            $result['hallsId'],
            $result['movieId'],
            $result['startTime'],
            $result['endTime']
        );
    }

    public function insert(array $rawMoviesSessionsData): MoviesSessions
    {
        $this->insertStatement->execute([
            $rawMoviesSessionsData['hallsId'],
            $rawMoviesSessionsData['movieId'],
            $rawMoviesSessionsData['startTime'],
            $rawMoviesSessionsData['endTime']
        ]);

        return new MoviesSessions(
            (int)$this->pdo->lastInsertId(),
            $rawMoviesSessionsData['hallsId'],
            $rawMoviesSessionsData['movieId'],
            $rawMoviesSessionsData['startTime'],
            $rawMoviesSessionsData['endTime']
        );
    }

    public function update(MoviesSessions $movies): bool
    {
        return $this->updateStatement->execute([
            $movies->getHallsId(),
            $movies->getMovieId(),
            $movies->getStartTime(),
            $movies->getEndTime()
        ]);
    }
}
