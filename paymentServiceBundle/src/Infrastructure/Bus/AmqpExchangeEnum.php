<?php

namespace PaymentServiceBundle\Infrastructure\Bus;

enum AmqpExchangeEnum: string
{
    case PaymentCreate = 'payment_service_payment_create';
    case PaymentUpdate = 'payment_service_payment_update';
    case PaymentDelete = 'payment_service_payment_delete';
    case ReportCreate  = 'payment_service_report_create';
    case SendEmail     = 'payment_service_send_email';
}
