<?php

namespace App\Application\UseCase\GetNewsReport;

class GetNewsReportRequest
{
    public function __construct(
        public readonly array $ids
    )
    {
    }

}
