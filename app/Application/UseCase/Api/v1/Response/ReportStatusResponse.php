<?php

declare(strict_types=1);

namespace App\Application\UseCase\Api\v1\Response;

use App\Domain\Enum\QueueReport\QueueReportStatusEnum;

final readonly class ReportStatusResponse
{
    public function __construct(
        public QueueReportStatusEnum $status,
    ) {
    }
}
