<?php

declare(strict_types=1);

namespace App\Application\Validator;

use App\Application\UseCase\Request\GenerateReportRequest;

interface GenerateReportValidatorInterface
{
    public function validate(GenerateReportRequest $generateReportRequest): void;
}
