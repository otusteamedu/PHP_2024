<?php

declare(strict_types=1);

namespace Irayu\Hw13\Infrastructure\Repository\Mysql\Mapper;

use Irayu\Hw13\Domain\Competition;
use Irayu\Hw13\Infrastructure\Repository\Mysql;
use PDO;

class CompetitionMapper
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findCompetitionById(int $id): ?Competition
    {
        $stmt = $this->pdo->prepare('SELECT * FROM boulder_competitions WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $competitionData = $stmt->fetch();

        if (!$competitionData) {
            return null;
        }

        return $this->mapToEntity($competitionData);
    }

    public function mapToEntity(array $competitionData): Competition
    {
        return new Competition(
            $competitionData['id'],
            $competitionData['name'],
            $competitionData['location'],
            \DateTime::createFromFormat('Y-m-d H:i:s', $competitionData['start_date']),
            \DateTime::createFromFormat('Y-m-d H:i:s', $competitionData['finish_date']),
            new Mysql\LazyLoadVO\BoulderProblemCollection(
                $this,
                $competitionData['id']
            )
        );
    }

    public function getBoulderProblemsByCompetitionId(int $competitionId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM boulder_problems WHERE competition_id = :competition_id');
        $stmt->execute(['competition_id' => $competitionId]);

        return $stmt->fetchAll();
    }

    public function save(Competition $competition): void
    {
        // TODO Make it
    }
}
