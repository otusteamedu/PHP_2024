<?php

namespace PaymentServiceBundle\Controller\http\Payment\Update\v2;

use PaymentServiceBundle\Domain\Bus\PaymentUpdateBusInterface;
use PaymentServiceBundle\Domain\DTO\Bus\PaymentUpdateDTO;
use Symfony\Component\Uid\Uuid;

class Handler
{
    public function __construct(
        private readonly PaymentUpdateBusInterface $paymentUpdateBus,
    ) {
    }

    public function update(RequestDTO $requestDTO, string $parentUuid): string
    {
        $uuid = Uuid::v1();

        $paymentUpdateDTO = new PaymentUpdateDTO(
            $uuid,
            $parentUuid,
            $requestDTO->amount,
            $requestDTO->purpose
        );

        $this->paymentUpdateBus->sendPaymentUpdateMessage($paymentUpdateDTO);

        return $uuid;
    }
}
