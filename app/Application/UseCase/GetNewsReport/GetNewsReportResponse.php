<?php

namespace Application\UseCase\GetNewsReport;

class GetNewsReportResponse
{
    public function __construct(
        public readonly string $link,
    )
    {
    }

}
