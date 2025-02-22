<?php

namespace App\Application\GeneratorReport;

interface ReportGeneratorInterface
{
    /**
     * @param ReportGeneratorRequest[] $feeds
     */
    public function generateReport(array $feeds): ReportGeneratorResponse;
}
