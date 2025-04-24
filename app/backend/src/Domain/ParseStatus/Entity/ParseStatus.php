<?php

namespace AnatolyShilyaev\Backend\Domain\ParseStatus\Entity;

use AnatolyShilyaev\Backend\Domain\ParseStatus\ValueObject\Status;

class ParseStatus
{
    public function __construct(
        private Status $status,
    ) {
        // Empty constructor
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function toArray(): array
    {
        return [
            'status' => $this->status->getValue(),
        ];
    }
}
