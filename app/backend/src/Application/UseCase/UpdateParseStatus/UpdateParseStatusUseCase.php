<?php

namespace AnatolyShilyaev\Backend\Application\UseCase\UpdateParseStatus;

use AnatolyShilyaev\Backend\Domain\ParseStatus\Factory\ParseStatusFactoryInterface;
use AnatolyShilyaev\Backend\Domain\ParseStatus\Repository\ParseStatusRepositoryInterface;
use AnatolyShilyaev\Backend\Domain\ParseStatus\ValueObject\Status;

class UpdateParseStatusUseCase
{
    public function __construct(
        private readonly ParseStatusFactoryInterface $factory,
        private readonly ParseStatusRepositoryInterface $repository,
    ) {
        // Empty constructor
    }

    public function __invoke(UpdateParseStatusRequest $updateParseStatusRequest)
    {
        $status = new Status($updateParseStatusRequest->status);

        $parseStatus = $this->factory->create($status);
        $this->repository->updateStatus($parseStatus);
    }
}
