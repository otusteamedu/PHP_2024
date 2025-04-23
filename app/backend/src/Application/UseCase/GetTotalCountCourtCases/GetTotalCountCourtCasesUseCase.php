<?php

namespace AnatolyShilyaev\Backend\Application\UseCase\GetTotalCountCourtCases;

use AnatolyShilyaev\Backend\Infrastructure\Repository\CourtCaseRepository;

class GetTotalCountCourtCasesUseCase
{
    public function __construct(
        private readonly CourtCaseRepository $repository,
    ) {
        // Empty constructor
    }

    public function __invoke()
    {
        return $this->repository->getTotalCount();
    }
}
