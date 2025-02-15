<?php

namespace App\Application\Service\Feed\DTO;

class ReportFeedResponse
{
    function __construct(
        public string $fileName,
    )
    {
    }
}
