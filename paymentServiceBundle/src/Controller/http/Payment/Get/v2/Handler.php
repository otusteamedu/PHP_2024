<?php

namespace PaymentServiceBundle\Controller\http\Payment\Get\v2;

use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestStatusEnum;
use PaymentServiceBundle\Domain\Service\PaymentRequestService;

class Handler
{
    private const MESSAGE = 'not found';

    public function __construct(
        private readonly PaymentRequestService $paymentRequestService,
    ) {
    }

    public function get(string $uuid): OutputNotificationDTO
    {
        $request = $this->paymentRequestService->getRequestModelByUuid($uuid);

        if ($request !== null) {
            if ($request->status === RequestStatusEnum::Success->value) {
                $paymentDTO = new OutputPaymentDTO(
                    $request->uuid,
                    $request->status,
                    $request->type,
                    $request->amount,
                    $request->purpose,
                    $request->createdAt,
                );

                return new OutputNotificationDTO(
                    $paymentDTO,
                    null,
                );
            }

            return new OutputNotificationDTO(
                null,
                ['message' => $request->status],
            );
        }

        return new OutputNotificationDTO(
                null,
                ['message' => self::MESSAGE],
        );
    }
}
