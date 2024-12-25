<?php

namespace PaymentServiceBundle\Controller\http\Payment\Get\v2;

class OutputNotificationDTO
{
    public function __construct(
        public readonly ?OutputPaymentDTO $paymentDTO,
        public readonly ?array            $message,
    ) {
    }
}
