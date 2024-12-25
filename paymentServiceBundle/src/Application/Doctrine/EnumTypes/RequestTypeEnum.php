<?php

namespace PaymentServiceBundle\Application\Doctrine\EnumTypes;

enum RequestTypeEnum: string
{
    case CreatePayment = 'payment_add';
    case ReadPayment   = 'payment_get';
    case UpdatePayment = 'payment_update';
    case DeletePayment = 'payment_delete';

    case GetTransactionReport = 'transaction_report';
}

