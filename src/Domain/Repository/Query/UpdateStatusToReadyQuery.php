<?php

declare(strict_types=1);

namespace Alogachev\Homework\Domain\Repository\Query;

readonly class UpdateStatusToReadyQuery
{
    public function __construct(
        public int $statementId,
        public string $status,
        public string $statementFileName,
    ) {
    }
}
