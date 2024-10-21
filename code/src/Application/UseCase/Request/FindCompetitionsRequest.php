<?php

declare(strict_types=1);

namespace Irayu\Hw13\Application\UseCase\Request;

use Irayu\Hw13\Domain;

class FindCompetitionsRequest
{
    public function __construct(
        public Domain\Repository\CompetitionRepositoryInterface $competitionRepository,
        protected readonly ?string $filterJson = null,
        protected readonly ?array $filter = null,
        public readonly ?int $limit = null,
    ) {
    }

    public function getFilter(): ?array
    {
        if (!empty($this->filterJson)) {
            return json_decode($this->filterJson, true);
        }

        return $this->filter;
    }
}
