<?php

namespace PaymentServiceBundle\Domain\Model\PaymentRequest\InputModel;

use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestStatusEnum;
use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestTypeEnum;
use PaymentServiceBundle\Domain\Entity\Request;
use PaymentServiceBundle\Domain\Model\PaymentRequest\Interface\PaymentRequestModelInterface;

class UpdatePaymentRequestModel implements PaymentRequestModelInterface
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $parentRequest,
        public readonly ?int $userId,
        public readonly RequestTypeEnum $type,
        public readonly RequestStatusEnum $status,
        public readonly ?int $amount,
        public readonly ?string $purpose
    ) {
    }
}
