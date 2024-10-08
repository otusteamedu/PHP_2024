<?php

declare(strict_types=1);


namespace Irayu\Hw13\Infrastructure\Repository\Mysql;

use Irayu\Hw0\Infrastructure\Repository\Competition;
use Irayu\Hw0\Infrastructure\Repository\CompetitionMapper;
use Irayu\Hw0\Infrastructure\Repository\IdentityMap;
use Irayu\Hw0\Infrastructure\Repository\LazyLoader;

class CompetitionRepository
{
    public function __construct(
        private CompetitionMapper $dataMapper,
        private IdentityMap $identityMap,
        private LazyLoader $lazyLoader
    ) {
    }

    public function findById($competitionId): ?Competition {

        $competition = $this->identityMap->get('Competition', $competitionId);
        if ($competition === null && $competitionData = $this->dataMapper->find($competitionId)) {
            $competition = $this->dataMapper->mapToEntity($competitionData);
            $this->identityMap->add($competition);
        }

        return $competition;
    }

    public function save(Competition $competition) {
        $this->dataMapper->save($competition);
        $this->identityMap->add($competition);
    }

    public function loadRelatedEntities(Competition $competition) {
        $this->lazyLoader->load('CompetitionItems', $competition);
    }
}
