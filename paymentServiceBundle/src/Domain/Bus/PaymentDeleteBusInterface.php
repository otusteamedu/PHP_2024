<?php

namespace PaymentServiceBundle\Domain\Bus;

use PaymentServiceBundle\Domain\DTO\Bus\PaymentDeleteDTO;

interface PaymentDeleteBusInterface
{
    public function sendPaymentDeleteMessage(PaymentDeleteDTO $paymentDeleteDTO): bool;
}
