<?php

declare(strict_types=1);

namespace App\Application\Service\DTO;

use App\Domain\ValueObject\Url;

readonly class ReportGeneratorOutputDto
{
    public function __construct(
        public Url $reportUrl,
    ) {
    }
}
