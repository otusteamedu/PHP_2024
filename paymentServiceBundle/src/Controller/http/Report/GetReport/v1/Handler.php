<?php

namespace PaymentServiceBundle\Controller\http\Report\GetReport\v1;

use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestStatusEnum;
use PaymentServiceBundle\Domain\Entity\Report;

class Handler
{
    public function get(?Report $report): bool|array
    {
        if ($report === null) {
            return false;
        }

        if ($report->getStatus() ===  RequestStatusEnum::Success) {
            return [$report->getBody()];
        }

        if ($report->getStatus() ===  RequestStatusEnum::Error) {
            return ['message' => RequestStatusEnum::Error->value];
        }

        return ['message' => 'request in process'];
    }
}
