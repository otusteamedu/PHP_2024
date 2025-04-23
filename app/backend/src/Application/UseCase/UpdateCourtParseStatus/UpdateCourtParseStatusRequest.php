<?php

namespace AnatolyShilyaev\Backend\Application\UseCase\UpdateCourtParseStatus;

class UpdateCourtParseStatusRequest
{
    public function __construct(
        public readonly string $courtCaseID,
        public readonly string $status,
        public readonly ?string $errorType = null,
    ) {
        // Empty constructor
    }
}
