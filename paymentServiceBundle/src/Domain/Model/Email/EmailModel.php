<?php

namespace PaymentServiceBundle\Domain\Model\Email;

use PaymentServiceBundle\Application\Mailer\EmailSubjectEnum;

class EmailModel
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $email,
        public readonly EmailSubjectEnum $emailSubject
    ) {
    }
}
