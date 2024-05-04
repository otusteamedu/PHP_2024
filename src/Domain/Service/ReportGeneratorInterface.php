<?php

declare(strict_types=1);

namespace App\Domain\Service;

interface ReportGeneratorInterface
{
    public function generateReport(array $data): string;
}
