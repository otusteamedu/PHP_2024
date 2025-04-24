<?php

namespace AnatolyShilyaev\Backend\Application\UseCase\GetParseStatus;

use AnatolyShilyaev\Backend\Domain\ParseStatus\Repository\ParseStatusRepositoryInterface;

class GetParseStatusUseCase
{
    public function __construct(
        private readonly ParseStatusRepositoryInterface $repository,
    ) {
        // Empty constructor
    }

    public function __invoke()
    {
        $status = $this->repository->getStatus();
        return $status->toArray();
    }
}
