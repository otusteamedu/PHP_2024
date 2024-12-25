<?php

namespace PaymentServiceBundle\Domain\Service;

use PaymentServiceBundle\Domain\Bus\PaymentCreateBusInterface;
use PaymentServiceBundle\Domain\Bus\PaymentDeleteBusInterface;
use PaymentServiceBundle\Domain\Bus\PaymentUpdateBusInterface;
use PaymentServiceBundle\Domain\Bus\ReportCreateBusInterface;
use PaymentServiceBundle\Domain\Bus\EmailRabbitMqBusInterface;
use PaymentServiceBundle\Domain\DTO\Bus\EmailDTO;
use PaymentServiceBundle\Domain\DTO\Bus\PaymentCreateDTO;
use PaymentServiceBundle\Domain\DTO\Bus\PaymentDeleteDTO;
use PaymentServiceBundle\Domain\DTO\Bus\PaymentUpdateDTO;
use PaymentServiceBundle\Domain\DTO\Bus\ReportCreateDTO;

class BusService
{
    public function __construct(
        private readonly PaymentCreateBusInterface $paymentCreateBus,
        private readonly PaymentUpdateBusInterface $paymentUpdateBus,
        private readonly PaymentDeleteBusInterface $paymentDeleteBus,
        private readonly ReportCreateBusInterface  $reportCreateBus,
        private readonly EmailRabbitMqBusInterface $sendEmailRabbitMqBus,
    ) {
    }

    public function sendPaymentCreateMessage(PaymentCreateDTO $paymentCreateDTO): bool
    {
        return $this->paymentCreateBus->sendPaymentCreateMessage($paymentCreateDTO);
    }

    public function sendPaymentUpdateMessage(PaymentUpdateDTO $paymentUpdateDTO): bool
    {
        return $this->paymentUpdateBus->sendPaymentUpdateMessage($paymentUpdateDTO);
    }

    public function sendPaymentDeleteMessage(PaymentDeleteDTO $paymentDeleteDTO): bool
    {
        return $this->paymentDeleteBus->sendPaymentDeleteMessage($paymentDeleteDTO);
    }

    public function sendReportCreateMessage(ReportCreateDTO $reportCreateDTO): bool
    {
        return $this->reportCreateBus->sendReportCreateMessage($reportCreateDTO);
    }

    public function sendEmailMessage(EmailDTO $emailSendDTO): bool
    {
        return $this->sendEmailRabbitMqBus->sendEmailMessage($emailSendDTO);
    }
}
