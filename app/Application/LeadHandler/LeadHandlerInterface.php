<?php

namespace App\Application\LeadHandler;

use App\Domain\Entity\Lead;

interface LeadHandlerInterface
{
    public function handle(Lead $lead): LeadHandlerResult;
}
