<?php

declare(strict_types=1);

namespace Alogachev\Homework\Domain\Repository\Query;

readonly class FindBankStatementQuery
{
    public function __construct(
        public int $id,
    ) {
    }
}
