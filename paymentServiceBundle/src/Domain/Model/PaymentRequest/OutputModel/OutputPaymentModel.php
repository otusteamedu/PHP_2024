<?php

namespace PaymentServiceBundle\Domain\Model\PaymentRequest\OutputModel;

class OutputPaymentModel
{
    public function __construct(
        public readonly bool   $isDeleted,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly int    $amount,
        public readonly string $purpose,
        public readonly array  $requestArray,
    ) {
    }
}
