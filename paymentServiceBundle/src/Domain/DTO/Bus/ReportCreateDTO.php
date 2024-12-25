<?php

namespace PaymentServiceBundle\Domain\DTO\Bus;

class ReportCreateDTO
{
    public function __construct(
        public readonly string  $uuid,
        public readonly int     $userId,
        public readonly ?string $userEmail,
        public readonly string  $periodBegin,
        public readonly string  $periodEnd,
        public readonly ?bool   $showDeleted,
    ) {
    }
}
