<?php

declare(strict_types=1);

namespace App\Application\UseCase\Report;

use App\Domain\Entity\News;

class ReportResponse
{
    /**
     * @param string $reportUrl
     */
    public function __construct(
        public string $reportUrl
    ) {
    }
}
