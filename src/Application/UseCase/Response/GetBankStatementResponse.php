<?php

declare(strict_types=1);

namespace Alogachev\Homework\Application\UseCase\Response;

use Alogachev\Homework\Domain\ValueObject\BankStatementStatus;

readonly class GetBankStatementResponse
{
    public function __construct(
        public int $id,
        public string $clientName,
        public string $accountNumber,
        public string $startDate,
        public string $endDate,
        public string $status,
    ) {
    }
}
