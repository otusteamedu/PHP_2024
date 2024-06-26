<?php

declare(strict_types=1);

namespace Alogachev\Homework\Application\UseCase\Response;

readonly class GenerateBankStatementResponse
{
    public function __construct(
        public int $statementId,
    ) {
    }
}
