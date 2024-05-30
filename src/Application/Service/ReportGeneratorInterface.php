<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Service\DTO\ReportGeneratorInputDto;
use App\Application\Service\DTO\ReportGeneratorOutputDto;

interface ReportGeneratorInterface
{
    public function generateReport(ReportGeneratorInputDto $inputDto): ReportGeneratorOutputDto;
}
