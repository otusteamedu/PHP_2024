<?php

namespace PaymentServiceBundle\Domain\Bus;

use PaymentServiceBundle\Domain\DTO\Bus\PaymentCreateDTO;

interface PaymentCreateBusInterface
{
    public function sendPaymentCreateMessage(PaymentCreateDTO $paymentCreateDTO): bool;
}
