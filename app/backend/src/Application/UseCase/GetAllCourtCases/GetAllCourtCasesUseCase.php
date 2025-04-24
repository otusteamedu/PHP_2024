<?php

namespace AnatolyShilyaev\Backend\Application\UseCase\GetAllCourtCases;

use AnatolyShilyaev\Backend\Infrastructure\Repository\CourtCaseRepository;

class GetAllCourtCasesUseCase
{
    public function __construct(
        private readonly CourtCaseRepository $repository,
    ) {
        // Empty constructor
    }

    public function __invoke()
    {
        return $this->repository->getAll();
    }
}
