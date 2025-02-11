<?php

declare(strict_types=1);

namespace App\Application\Gateway\ReportGenerator;

interface ReportGenerator
{
    public function generate(ReportGeneratorRequest $request): ReportGeneratorResponse;
}