<?php

namespace PaymentServiceBundle\Domain\Service;

use Doctrine\Common\Collections\ArrayCollection;
use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestStatusEnum;
use PaymentServiceBundle\Domain\Entity\Payment;
use PaymentServiceBundle\Domain\Entity\Request;
use PaymentServiceBundle\Domain\Factory\ModelFactory;
use PaymentServiceBundle\Domain\Model\PaymentRequest\InputModel\CreatePaymentRequestModel;
use PaymentServiceBundle\Domain\Model\PaymentRequest\InputModel\DeletePaymentRequestModel;
use PaymentServiceBundle\Domain\Model\PaymentRequest\InputModel\UpdatePaymentRequestModel;
use PaymentServiceBundle\Domain\Model\PaymentRequest\Interface\PaymentRequestModelInterface;
use PaymentServiceBundle\Domain\Model\PaymentRequest\OutputModel\OutputPaymentModel;
use PaymentServiceBundle\Domain\Model\PaymentRequest\OutputModel\OutputRequestModel;
use PaymentServiceBundle\Domain\Model\Report\InputReportModel;
use PaymentServiceBundle\Domain\Repository\PaymentRepositoryInterface;
use PaymentServiceBundle\Domain\Repository\RequestRepositoryInterface;

class PaymentRequestService
{
    public function __construct(
        private readonly ModelFactory $modelFactory,
        private readonly RequestRepositoryInterface $requestRepository,
        private readonly PaymentRepositoryInterface $paymentRepository,
    ) {
    }

    public function createPaymentRequest(CreatePaymentRequestModel $model): void
    {
        $request = $this->makeRequest($model);
        $this->requestRepository->createRequest($request);

        $payment = $this->makePayment($model, $request);
        $this->paymentRepository->createPayment($payment);

        $this->requestRepository->setRequestStatus($request, RequestStatusEnum::Success);
    }

    public function updatePaymentByRequest(UpdatePaymentRequestModel $model): void
    {
        $request = $this->makeRequest($model);
        $request = $this->requestRepository->createRequest($request);

        $payment = $this->paymentRepository->getPaymentByRequest($model->parentRequest);
        if (!$this->isPaymentExists($payment, $request)) {
            return;
        }
        $payment = $this->paymentRepository->updatePayment($model, $payment);

        $this->requestRepository->setRequestStatus($request, RequestStatusEnum::Success);
        $this->paymentRepository->addRequestToPayment($payment, $request);
    }

    public function deletePaymentByRequest(DeletePaymentRequestModel $model): void
    {
        $request = $this->makeRequest($model);
        $request = $this->requestRepository->createRequest($request);

        $payment = $this->paymentRepository->getPaymentByRequest($model->parentRequest);
        if (!$this->isPaymentExists($payment, $request)) {
            return;
        }
        $this->paymentRepository->deletePayment($payment);

        $this->requestRepository->setRequestStatus($request, RequestStatusEnum::Success);
        $this->paymentRepository->addRequestToPayment($payment, $request);
    }

    public function getUserIdByRequestUuid(string $uuid): ?int
    {
        return $this->requestRepository->getRequestByUuid($uuid)?->getUserId();
    }

    public function getRequestModelByUuid(string $uuid): ?OutputRequestModel
    {
        $request = $this->getRequestByUuid($uuid);

        if (!$request) {
            return null;
        }

        return $this->modelFactory->makeModel(
            OutputRequestModel::class,
            $request->getUuid(),
            $request->getParentRequest() ?? null,
            $request->getType()->value,
            $request->getStatus()->value,
            $request->getCreatedAt()->format('Y-m-d H:i:s'),
            $request->getUpdatedAt()->format('Y-m-d H:i:s'),
            $request->getAmount() ?? null,
            $request->getPurpose() ?? null,
        );
    }

    /**
     * @param InputReportModel $model
     * @return OutputPaymentModel[]
     */
    public function createReport(InputReportModel $model): array
    {
        $paymentArray = $this->paymentRepository->getPaymentArray($model);
        $modelPaymentArray = [];

        /** @var Payment $payment */
        foreach ($paymentArray as $payment) {
            $modelRequestArray = [];
            $requestArray = $payment->getRequests()->toArray();

            /** @var Request $request */
            foreach ($requestArray as $request) {
                $requestModel = $this->modelFactory->makeModel(
                    OutputRequestModel::class,
                    $request->getUuid(),
                    $request->getParentRequest() ?? null,
                    $request->getType()->value,
                    $request->getStatus()->value,
                    $request->getCreatedAt()->format('Y-m-d H:i:s'),
                    $request->getUpdatedAt()->format('Y-m-d H:i:s'),
                    $request->getAmount() ?? null,
                    $request->getPurpose() ?? null,
                );

                $modelRequestArray[] = $requestModel;
            }

            $paymentModel = $this->modelFactory->makeModel(
                OutputPaymentModel::class,
                (bool)$payment->getDeletedAt(),
                $payment->getCreatedAt()->format('Y-m-d H:i:s'),
                $payment->getUpdatedAt()->format('Y-m-d H:i:s'),
                $payment->getAmount(),
                $payment->getPurpose(),
                $modelRequestArray,
            );

            $modelPaymentArray[] = $paymentModel;
        }

        return $modelPaymentArray;
    }

    private function getRequestByUuid(string $uuid): ?Request
    {
        return $this->requestRepository->getRequestByUuid($uuid);
    }

    private function makeRequest(PaymentRequestModelInterface $model): Request
    {
        $request = new Request();
        $request->setUuid($model->uuid);
        $request->setParentRequest($model->parentRequest  ?? null);
        $request->setUserId($model->userId);
        $request->setType($model->type);
        $request->setStatus($model->status);
        $request->setAmount($model->amount ?? null);
        $request->setPurpose($model->purpose ?? null);

        return $request;
    }

    private function makePayment(PaymentRequestModelInterface $model, Request $request): Payment
    {
        $payment = new Payment();
        $payment->setUserId($model->userId);
        $payment->setAmount($model->amount);
        $payment->setPurpose($model->purpose);

        $requestCollection = new ArrayCollection([$request]);
        $payment->setRequests($requestCollection);

        return $payment;
    }

    private function isPaymentExists(?Payment $payment, Request $request): bool
    {
        if ($payment === null) {
            $this->requestRepository->setRequestStatus($request, RequestStatusEnum::Error);

            return false;
        }

        return true;
    }
}
