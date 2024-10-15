<?php

declare(strict_types=1);

namespace Irayu\Hw13\Application\UseCase;

use Irayu\Hw13\Domain;

class FindCompetitions
{
    protected ?array $filter;
    protected Domain\Repository\CompetitionRepositoryInterface $repo;
    protected ?int $limit;

    public function __construct(Request\FindCompetitionsRequest $request)
    {
        $this->filter = $request->getFilter();
        $this->repo = $request->competitionRepository;
        $this->limit = $request->limit;
    }

    public function run(): Response\FindCompetitionsResponse
    {
        $competitions = $this->repo->findByFilter(
            filter: $this->filter,
            sort: null,
            offset: null,
            limit: $this->limit
        );

        return new Response\FindCompetitionsResponse($competitions);
    }
}
