<?php

declare(strict_types=1);

namespace App\Application\Helper;

use App\Application\Helper\Request\ReportGeneratorRequest;
use App\Application\Helper\Response\ReportGeneratorResponse;

interface ReportGeneratorInterface
{
    public function generate(ReportGeneratorRequest $dto): ReportGeneratorResponse;
}
