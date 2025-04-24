<?php

namespace AnatolyShilyaev\Backend\Application\UseCase\UpdateParseStatus;

class UpdateParseStatusRequest
{
    public function __construct(
        public readonly bool $status,
    ) {
        // Empty constructor
    }
}
