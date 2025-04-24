<?php

namespace AnatolyShilyaev\Backend\Application\UseCase\UploadCourtCases;

class UploadCourtCasesRequest
{
    public function __construct(
        public readonly string $generalNumber,
        public readonly string $url
    ) {
        // Empty constructor
    }
}
