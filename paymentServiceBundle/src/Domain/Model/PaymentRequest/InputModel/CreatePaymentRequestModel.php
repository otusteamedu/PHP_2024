<?php

namespace PaymentServiceBundle\Domain\Model\PaymentRequest\InputModel;

use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestStatusEnum;
use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestTypeEnum;
use PaymentServiceBundle\Domain\Model\PaymentRequest\Interface\PaymentRequestModelInterface;

class CreatePaymentRequestModel implements PaymentRequestModelInterface
{
    public function __construct(
        public readonly string $uuid,
        public readonly int $userId,
        public readonly RequestTypeEnum $type,
        public readonly RequestStatusEnum $status,
        public readonly int $amount,
        public readonly string $purpose
    ) {
    }
}
