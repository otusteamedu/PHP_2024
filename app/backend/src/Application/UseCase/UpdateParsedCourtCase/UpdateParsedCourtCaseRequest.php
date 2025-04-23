<?php

namespace AnatolyShilyaev\Backend\Application\UseCase\UpdateParsedCourtCase;

class UpdateParsedCourtCaseRequest
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $title,
        public readonly ?string $uid,
        public readonly ?string $caseNumber,
        public readonly ?string $judgeFio,
        public readonly ?string $registerDate,
        public readonly ?array $events,
        public readonly ?array $parties,
    ) {
        // Empty constructor
    }
}
