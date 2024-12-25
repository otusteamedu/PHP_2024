<?php

namespace PaymentServiceBundle\Domain\Bus;

use PaymentServiceBundle\Domain\DTO\Bus\PaymentUpdateDTO;

interface PaymentUpdateBusInterface
{
    public function sendPaymentUpdateMessage(PaymentUpdateDTO $paymentUpdateDTO): bool;
}
