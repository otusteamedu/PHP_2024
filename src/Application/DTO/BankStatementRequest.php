<?php

declare(strict_types=1);

namespace Pozys\BankStatement\Application\DTO;

class BankStatementRequest
{
    public function __construct(
        public readonly string $dateFrom,
        public readonly string $dateTo,
        public readonly string $email
    ) {
    }

    public static function fromRequest(array $request): self
    {
        return new self($request['date_from'], $request['date_to'], $request['email']);
    }
}
