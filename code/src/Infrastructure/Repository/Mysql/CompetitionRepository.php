<?php

declare(strict_types=1);

namespace Irayu\Hw13\Infrastructure\Repository\Mysql;

use Irayu\Hw13\Domain;
use Irayu\Hw13\Infrastructure\Repository\Mysql\Mapper\CompetitionMapper;
use Irayu\Hw13\Infrastructure\Repository\IdentityMap;
use PDO;

class CompetitionRepository implements Domain\Repository\CompetitionRepositoryInterface
{
    public function __construct(
        private PDO $pdo,
        private CompetitionMapper $dataMapper,
        private IdentityMap $identityMap,
    ) {
    }

    public function findById($competitionId): ?Domain\Competition
    {
        $competition = $this->identityMap->get('Competition', $competitionId);
        if ($competition === null && $competitionData = $this->dataMapper->findCompetitionById($competitionId)) {
            $this->identityMap->add($competition);
        }

        return $competition;
    }

    /**
     * @return Domain\Competition[]
     */
    public function findByFilter(?array $filter, ?array $sort, ?int $offset, ?int $limit): array
    {
        $params = [];
        $sql = "SELECT * FROM boulder_competitions";

        if (!empty($filter)) {
            $sqlPlaceholder = [];
            foreach ($filter as $key => $value) {
                $sqlPlaceholder[] = "$key = :$key";
                $params[":$key"] = $value;
            }
            $sql .= " WHERE " . implode(' AND ', $sqlPlaceholder);
        }
        if (!empty($sort)) {
            $sql .= " ORDER BY ";
            foreach ($sort as $key => $value) {
                $sql .= " $key $value";
            }
        }
        if (!empty($offset)) {
            $sql .= " OFFSET $offset";
        }
        if (!empty($limit)) {
            $sql .= " LIMIT $limit";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $competitionIDs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $competitions = [];
        foreach ($competitionIDs as $competitionData) {
            $competition = $this->identityMap->get('Competition', $competitionData['id']);
            if ($competition === null) {
                $competition = $this->dataMapper->mapToEntity($competitionData);
                $this->identityMap->add($competition);
            }
            $competitions[] = $competition;
        }

        return $competitions;
    }

    public function save(Domain\Competition $competition)
    {
        $this->dataMapper->save($competition);
        $this->identityMap->add($competition);
    }
}
