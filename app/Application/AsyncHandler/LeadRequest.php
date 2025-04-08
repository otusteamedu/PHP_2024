<?php

namespace App\Application\AsyncHandler;

readonly class LeadRequest
{

    public function __construct(
        private int $leadId,
    )
    {
    }

    public function getLeadId(): int
    {
        return $this->leadId;
    }

    public function toArray(): array
    {
        return [
            'leadId' => $this->leadId,
        ];
    }
}
