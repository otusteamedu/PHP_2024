<?php

declare(strict_types=1);

namespace Alogachev\Homework\Application\UseCase\Response;

readonly class GenerateBankStatementResponse implements JsonResponseInterface
{
    public function __construct(
        public int $statementId,
    ) {
    }

    public function toArray(): array
    {
        return [
            'statementId' => $this->statementId,
        ];
    }
}
