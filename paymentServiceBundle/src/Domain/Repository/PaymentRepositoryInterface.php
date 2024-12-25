<?php

namespace PaymentServiceBundle\Domain\Repository;

use PaymentServiceBundle\Domain\Entity\Payment;
use PaymentServiceBundle\Domain\Entity\Request;
use PaymentServiceBundle\Domain\Model\PaymentRequest\InputModel\UpdatePaymentRequestModel;
use PaymentServiceBundle\Domain\Model\Report\InputReportModel;

interface PaymentRepositoryInterface
{
    public function createPayment(Payment $payment): void;

    public function updatePayment(
        UpdatePaymentRequestModel $updatePaymentRequestModel,
        Payment $payment
    ): Payment;

    public function deletePayment(Payment $payment): void;

    public function addRequestToPayment(Payment $payment, Request $request): void;

    public function getPaymentArray(InputReportModel $model): array;

    public function getPaymentByRequest(string $request): ?Payment;
}
