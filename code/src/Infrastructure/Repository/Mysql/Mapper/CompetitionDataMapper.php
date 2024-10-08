<?php

declare(strict_types=1);

namespace Irayu\Hw13\Infrastructure\Repository\Mysql\Mapper;

use Irayu\Hw13\Infrastructure\Mapper\Competition;
use Irayu\Hw13\Infrastructure\Mapper\PDO;

class CompetitionDataMapper
{
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function findCompetitionById(int $id): ?Competition {
        $stmt = $this->pdo->prepare('SELECT * FROM competitions WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $competitionData = $stmt->fetch();

        if (!$competitionData) {
            return null;
        }

        // Assume we also fetch Boulder problems
        $boulderProblems = $this->findBoulderProblemsByCompetitionId($id);

        return new Competition($competitionData['id'], $competitionData['name'], $boulderProblems);
    }

    public function findBoulderProblemsByCompetitionId(int $competitionId): array {
        $stmt = $this->pdo->prepare('SELECT * FROM boulder_problems WHERE competition_id = :competition_id');
        $stmt->execute(['competition_id' => $competitionId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save(Competition $competition): void {
        // Handle the insert or update logic for competition and boulder problems
        // Simplified for brevity
    }
}
