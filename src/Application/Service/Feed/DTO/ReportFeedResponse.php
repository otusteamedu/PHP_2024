<?php

namespace App\Application\Service\Feed\DTO;

readonly class ReportFeedResponse
{
    public function __construct(
        public string $fileName,
    ) {
    }
}
