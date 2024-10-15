<?php

declare(strict_types=1);

namespace Irayu\Hw13\Infrastructure\Repository\Mysql\LazyLoadVO;

use Irayu\Hw13\Domain\VO;
use Irayu\Hw13\Infrastructure\Repository\Mysql;

class BoulderProblemCollection extends VO\BoulderProblemCollection
{
    private bool $loaded = false;

    public function __construct(
        private Mysql\Mapper\CompetitionMapper $mapper,
        private int $competitionId,
    ) {
        parent::__construct([]);
    }

    public function getLoaded(): static
    {
        if (!$this->loaded) {
            $this->loaded = true;
            parent::__construct(
                $this->mapper->getBoulderProblemsByCompetitionId($this->competitionId)
            );
        }

        return $this;
    }
}
