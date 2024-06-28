<?php

declare(strict_types=1);

namespace Alogachev\Homework\Application\UseCase\Request;

readonly class GetBankStatementRequest
{
    public function __construct(
        public int $id,
    ) {
    }
}
