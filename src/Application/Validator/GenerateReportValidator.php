<?php

declare(strict_types=1);

namespace App\Application\Validator;

use App\Application\UseCase\Request\GenerateReportRequest;
use InvalidArgumentException;

class GenerateReportValidator implements GenerateReportValidatorInterface
{
    public function validate(GenerateReportRequest $generateReportRequest): void
    {
        if (empty($generateReportRequest->ids)) {
            throw new InvalidArgumentException('IDs is required.');
        }

        foreach ($generateReportRequest->ids as $id) {
            if (!is_int($id)) {
                throw new InvalidArgumentException('All IDs must be integers.');
            }
        }
    }
}
