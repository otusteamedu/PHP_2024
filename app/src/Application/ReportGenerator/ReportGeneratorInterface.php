<?php

namespace Anatolyshilyaev\Hw14\Application\ReportGenerator;

interface ReportGeneratorInterface
{
    /**
     * @param ReportGeneratorRequest[] $reportGeneratorRequest
     * @return ?ReportGeneratorResponse $reportGeneratorResponse
     */
    public function generate(array $reportGeneratorRequest): ?ReportGeneratorResponse;
}
