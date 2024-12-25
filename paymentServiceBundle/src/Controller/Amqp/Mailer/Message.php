<?php

namespace PaymentServiceBundle\Controller\Amqp\Mailer;

use PaymentServiceBundle\Application\Mailer\EmailSubjectEnum;

class Message
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $email,
        public readonly EmailSubjectEnum $emailSubject
    ) {
    }
}
