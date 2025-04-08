<?php

namespace App\Application\AsyncHandler;

class LeadRequest
{

    public function __construct(
        private readonly int    $leadId,
    )
    {
    }

    public function getLeadId(): int
    {
        return $this->leadId;
    }

}
