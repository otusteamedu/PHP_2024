<?php

namespace PaymentServiceBundle\Domain\Model\PaymentRequest\OutputModel;

class OutputRequestModel
{
    public function __construct(
        public readonly string  $uuid,
        public readonly ?string $parentUuid,
        public readonly string  $type,
        public readonly string  $status,
        public readonly string  $createdAt,
        public readonly string  $updatedAt,
        public readonly ?int    $amount,
        public readonly ?string $purpose,
    ) {
    }
}
