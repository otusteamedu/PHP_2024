<?php

namespace PaymentServiceBundle\Domain\Model\Report;

use DateTime;
use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestStatusEnum;

class InputReportModel
{
    public function __construct(
        public readonly string            $uuid,
        public readonly int               $userId,
        public readonly ?string           $userEmail,
        public readonly RequestStatusEnum $status,
        public readonly DateTime          $periodBegin,
        public readonly DateTime          $periodEnd,
        public          ?array            $body,
        public readonly ?bool             $showDeleted,
    ) {
    }
}
