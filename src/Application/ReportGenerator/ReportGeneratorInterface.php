<?php

declare(strict_types=1);

namespace App\Application\ReportGenerator;

use App\Application\ReportGenerator\Request\ReportGeneratorRequest;

interface ReportGeneratorInterface
{
    public function generate(ReportGeneratorRequest $dto): void;
}
