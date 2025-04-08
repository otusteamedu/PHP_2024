<?php

namespace App\Application\LeadHandler;

class LeadHandlerResult
{

    public function __construct(
        public string $status,
        public int $sum,
        public string $message,
    )
    {
    }
}
