<?php

namespace PaymentServiceBundle\Controller\http\Payment\Create\v2;

use PaymentServiceBundle\Domain\DTO\Bus\PaymentCreateDTO;
use PaymentServiceBundle\Domain\Service\BusService;
use Symfony\Component\Uid\Uuid;

class Handler
{
    public function __construct(
        private readonly BusService $busService,
    ) {
    }

    public function create(RequestDTO $requestDTO): string
    {
        $uuid = Uuid::v1();

        $paymentCreateDTO = new PaymentCreateDTO(
            $uuid,
            $requestDTO->userId,
            $requestDTO->amount,
            $requestDTO->purpose
        );

        if ($this->busService->sendPaymentCreateMessage($paymentCreateDTO)) {
            return $uuid;
        }

        return 'The service is temporarily unavailable. Try again later.';
    }
}
