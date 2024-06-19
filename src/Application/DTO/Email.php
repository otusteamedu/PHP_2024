<?php

declare(strict_types=1);

namespace Pozys\BankStatement\Application\DTO;

class Email
{
    public function __construct(
        public readonly string $to,
        public readonly string $subject,
        public readonly string $message
    ) {
    }
}
