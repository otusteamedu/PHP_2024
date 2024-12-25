<?php

namespace PaymentServiceBundle\Infrastructure\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use PaymentServiceBundle\Domain\Entity\Payment;
use PaymentServiceBundle\Domain\Entity\Request;
use PaymentServiceBundle\Domain\Model\PaymentRequest\InputModel\UpdatePaymentRequestModel;
use PaymentServiceBundle\Domain\Model\Report\InputReportModel;
use PaymentServiceBundle\Domain\Repository\PaymentRepositoryInterface;

class PaymentRepository implements PaymentRepositoryInterface
{
    private const TIME = 10;

    public function __construct(protected readonly EntityManagerInterface $entityManager)
    {
    }

    public function createPayment(Payment $payment): void
    {
        $this->timeProcessing();

        $this->entityManager->persist($payment);
        $this->entityManager->flush();
    }

    public function updatePayment(
        UpdatePaymentRequestModel $updatePaymentRequestModel,
        Payment $payment
    ): Payment {
        $this->timeProcessing();

        if ($updatePaymentRequestModel->amount) {
            $payment->setAmount($updatePaymentRequestModel->amount);
        }

        if ($updatePaymentRequestModel->purpose) {
            $payment->setAmount($updatePaymentRequestModel->purpose);
        }

        $this->entityManager->persist($payment);
        $this->entityManager->flush();

        return $payment;
    }

    public function deletePayment(Payment $payment): void
    {
        $this->timeProcessing();

        $this->entityManager->remove($payment);
        $this->entityManager->flush();
    }

    public function addRequestToPayment(Payment $payment, Request $request): void
    {
        $payment->setRequests(new ArrayCollection([$request]));
        $this->entityManager->flush();
    }

    public function getPaymentArray(InputReportModel $model): array
    {
        if ($model->showDeleted) {
            $this->entityManager->getFilters()->disable('softdeleteable');
        }

        $query =  $this->entityManager->createQuery(
            'SELECT Payment
            FROM PaymentServiceBundle\Domain\Entity\Payment Payment
            WHERE Payment.createdAt >= :periodBegin
            AND   Payment.updatedAt <= :periodEnd
            AND   Payment.userId = :userId'
        );
        $query->setParameter('periodBegin', $model->periodBegin);
        $query->setParameter('periodEnd', $model->periodEnd);
        $query->setParameter('userId', $model->userId);

        return $query->getResult();
    }

    public function getPaymentByRequest(string $request): ?Payment
    {
        $query =  $this->entityManager->createQuery(
            'SELECT Payment
            FROM PaymentServiceBundle\Domain\Entity\Payment Payment
            WHERE :request MEMBER OF Payment.requests'
        );
        $query->setParameter('request', $request);

        $resultArray = $query->getResult();

        return count($resultArray) > 0 ? $resultArray[0] : null;
    }

    private function timeProcessing(): void
    {
        sleep(self::TIME);
    }
}
