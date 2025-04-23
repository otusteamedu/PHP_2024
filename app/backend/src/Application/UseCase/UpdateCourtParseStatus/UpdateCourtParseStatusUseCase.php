<?php

namespace AnatolyShilyaev\Backend\Application\UseCase\UpdateCourtParseStatus;

use AnatolyShilyaev\Backend\Domain\CourtParseStatus\ValueObject\CourtCaseID;
use AnatolyShilyaev\Backend\Domain\CourtParseStatus\ValueObject\ErrorType;
use AnatolyShilyaev\Backend\Domain\CourtParseStatus\ValueObject\Status;
use AnatolyShilyaev\Backend\Infrastructure\Factory\CourtParseStatusFactory;
use AnatolyShilyaev\Backend\Infrastructure\Repository\CourtParseStatusRepository;

class UpdateCourtParseStatusUseCase
{
    public function __construct(
        private readonly CourtParseStatusFactory $factory,
        private readonly CourtParseStatusRepository $repository,
    ) {
        // Empty constructor
    }

    public function __invoke(UpdateCourtParseStatusRequest $request): void
    {
        //Prepare ValueObjects
        $courtCaseID = new CourtCaseID($request->courtCaseID);
        $status = new Status($request->status);
        $errorType = new ErrorType($request->errorType);

        // Create CourtParseStatus
        $courtParseStatus = $this->factory->create($courtCaseID, $status, $errorType, null);

        //Save news to DB
        $this->repository->update($courtParseStatus);
    }
}
