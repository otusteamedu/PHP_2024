<?php

namespace PaymentServiceBundle\Controller\http\Payment\Delete\v2;

use PaymentServiceBundle\Domain\Bus\PaymentDeleteBusInterface;
use PaymentServiceBundle\Domain\DTO\Bus\PaymentDeleteDTO;
use Symfony\Component\Uid\Uuid;

class Handler
{
    public function __construct(
        private readonly PaymentDeleteBusInterface $paymentDeleteBus,
    ) {
    }

    public function delete(string $parentUuid): string
    {
        $uuid = Uuid::v1();

        $paymentDeleteDTO = new PaymentDeleteDTO(
            $uuid,
            $parentUuid,
        );

        $this->paymentDeleteBus->sendPaymentDeleteMessage($paymentDeleteDTO);

        return $uuid;
    }
}
