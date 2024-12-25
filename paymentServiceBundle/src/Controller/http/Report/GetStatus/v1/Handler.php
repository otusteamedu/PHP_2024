<?php

namespace PaymentServiceBundle\Controller\http\Report\GetStatus\v1;

use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestStatusEnum;
use PaymentServiceBundle\Controller\BundleUrlPrefixEnum\BundleUrlPrefixEnum;
use PaymentServiceBundle\Domain\Entity\Report;

class Handler
{
    private const SITE_URL_PREFIX = BundleUrlPrefixEnum::PaymentService->value;
    private const CONTROLLER_URL_PREFIX = BundleUrlPrefixEnum::LinkForShowReport->value;

    public function __construct(
        private readonly string $appSite,
    ) {
    }

    public function get(?Report $report): bool|array
    {
        if ($report === null) {
            return false;
        }

        if ($report->getStatus() ===  RequestStatusEnum::Success) {
            return [
                'message' => 'request is ' . RequestStatusEnum::Success->value,
                'linkForShow' => 'http://' . $this->appSite . '/'
                                    . self::SITE_URL_PREFIX
                                    . self::CONTROLLER_URL_PREFIX
                                    . $report->getUuid()
            ];
        }

        if ($report->getStatus() ===  RequestStatusEnum::Error) {
            return [
                'message' => 'request is ' . RequestStatusEnum::Error->value,
            ];
        }

        return ['message' => 'request in process'];
    }
}
