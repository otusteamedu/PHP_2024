<?php

namespace PaymentServiceBundle\Controller\http\Payment\Get\v1;

use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestStatusEnum;
use PaymentServiceBundle\Domain\Entity\Request;

class Handler
{
    public function get(?Request $request): bool|OutputPaymentDTO|array
    {
        if ($request === null) {
            return false;
        }

        if ($request->getStatus() ===  RequestStatusEnum::Success) {
            return new OutputPaymentDTO(
                $request->getUuid(),
                $request->getUserId(),
                $request->getType()->value,
                $request->getStatus()->value,
                $request->getAmount(),
                $request->getPurpose(),
                $request->getUpdatedAt()->format('yY-m-d H:i:s')
            );
        }

        if ($request->getStatus() ===  RequestStatusEnum::Error) {
            return ['message' => RequestStatusEnum::Error->value];
        }

        return ['message' => 'request in process'];
    }
}
