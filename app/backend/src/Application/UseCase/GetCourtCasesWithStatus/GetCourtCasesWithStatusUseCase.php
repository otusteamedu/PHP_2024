<?php

namespace AnatolyShilyaev\Backend\Application\UseCase\GetCourtCasesWithStatus;

use AnatolyShilyaev\Backend\Domain\CourtCaseWithStatus\Entity\CourtCaseWithStatus;
use AnatolyShilyaev\Backend\Domain\CourtCaseWithStatus\Repository\CourtCaseWithStatusRepositoryInterface;

class GetCourtCasesWithStatusUseCase
{
    public function __construct(
        private readonly CourtCaseWithStatusRepositoryInterface $repository,
    ) {
        // Empty constructor
    }

    public function __invoke()
    {
        $cases = $this->repository->getAll();

        return array_map(function (CourtCaseWithStatus $case) {
            return $case->toArray();
        }, $cases);
    }
}
