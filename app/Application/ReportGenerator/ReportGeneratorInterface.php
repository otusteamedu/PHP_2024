<?php

namespace App\Application\ReportGenerator;

interface ReportGeneratorInterface
{
    /**
     * @param ReportGeneratorRequest $request
     * @return ReportGeneratorResponse
     */
    public function generate(ReportGeneratorRequest $request): ReportGeneratorResponse;
}
