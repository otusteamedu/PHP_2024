<?php

namespace PaymentServiceBundle\Controller\BundleUrlPrefixEnum;

enum BundleUrlPrefixEnum: string
{
    case PaymentService    = 'payment-service';
    case LinkForShowReport = '/api/v1/payment-request-report/show/';
}
