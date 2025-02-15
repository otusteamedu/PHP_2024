<?php

namespace App\Application\Service\Feed\DTO;

class ReportFeedResponse
{
    public function __construct(
        public string $fileName,
    ) {
    }
}
