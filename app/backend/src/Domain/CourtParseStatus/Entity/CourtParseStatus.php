<?php

namespace AnatolyShilyaev\Backend\Domain\CourtParseStatus\Entity;

use AnatolyShilyaev\Backend\Domain\CourtParseStatus\ValueObject\CourtCaseID;
use AnatolyShilyaev\Backend\Domain\CourtParseStatus\ValueObject\ErrorType;
use AnatolyShilyaev\Backend\Domain\CourtParseStatus\ValueObject\Status;

class CourtParseStatus
{
    public function __construct(
        private CourtCaseID $courtCaseID,
        private Status $status,
        private ErrorType $errorType,
        private ?string $id = null,
    ) {
        // Empty constructor
    }

    public function getId(): ?string
    {
        return $this->id;
    }
    public function getCourtCaseID(): CourtCaseID
    {
        return $this->courtCaseID;
    }
    public function getStatus(): Status
    {
        return $this->status;
    }
    public function getErrorType(): ErrorType
    {
        return $this->errorType;
    }
}
