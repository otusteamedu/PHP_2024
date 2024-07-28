<?php

declare(strict_types=1);

namespace App\Application\UseCase\Console\Request;

use App\Domain\Enum\QueueReport\QueueReportStatusEnum;

final readonly class GenerateTransactionReportRequest
{
    public function __construct(
        public QueueReportStatusEnum $transactionStatus,
        public string $updatedAt,
        public string $filePath,
        public array $message,
    ) {
    }
}
