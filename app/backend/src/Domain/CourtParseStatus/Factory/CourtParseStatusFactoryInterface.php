<?php

namespace AnatolyShilyaev\Backend\Domain\CourtParseStatus\Factory;

use AnatolyShilyaev\Backend\Domain\CourtParseStatus\Entity\CourtParseStatus;
use AnatolyShilyaev\Backend\Domain\CourtParseStatus\ValueObject\CourtCaseID;
use AnatolyShilyaev\Backend\Domain\CourtParseStatus\ValueObject\ErrorType;
use AnatolyShilyaev\Backend\Domain\CourtParseStatus\ValueObject\Status;

interface CourtParseStatusFactoryInterface
{
    public function create(
        CourtCaseID $courtCaseID,
        Status $status,
        ErrorType $errorType,
        ?string $id = null,
    ): CourtParseStatus;
}
