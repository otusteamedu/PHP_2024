<?php

namespace PaymentServiceBundle\Controller\http\Report\Create\v2;

class RequestDTO
{
    public function __construct(
        public readonly int     $userId,
        public readonly ?string $userEmail,
        public readonly string  $periodBegin,
        public readonly string  $periodEnd,
        public readonly ?bool   $showDeleted,
    ) {
    }
}
