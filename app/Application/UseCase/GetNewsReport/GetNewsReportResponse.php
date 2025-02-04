<?php

namespace App\Application\UseCase\GetNewsReport;

class GetNewsReportResponse
{
    public function __construct(
        public readonly string $link,
    )
    {
    }

}
