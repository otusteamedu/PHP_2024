<?php

namespace PaymentServiceBundle\Domain\Bus;

use PaymentServiceBundle\Domain\DTO\Bus\EmailDTO;

interface EmailRabbitMqBusInterface
{
    public function sendEmailMessage(EmailDTO $emailSendDTO): bool;
}
