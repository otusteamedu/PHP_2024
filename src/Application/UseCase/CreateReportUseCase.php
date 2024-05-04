<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Response\CreateReportResponse;

class CreateReportUseCase
{
    public function __invoke(): CreateReportResponse
    {
        return new CreateReportResponse('report/path/report.html');
    }
}
