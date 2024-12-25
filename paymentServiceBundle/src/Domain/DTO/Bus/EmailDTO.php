<?php

namespace PaymentServiceBundle\Domain\DTO\Bus;

use PaymentServiceBundle\Application\Mailer\EmailSubjectEnum;

class EmailDTO
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $email,
        public readonly EmailSubjectEnum $emailSubject
    ) {
    }
}
