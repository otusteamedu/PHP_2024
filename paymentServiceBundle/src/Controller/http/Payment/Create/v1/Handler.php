<?php

namespace PaymentServiceBundle\Controller\http\Payment\Create\v1;

use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestStatusEnum;
use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestTypeEnum;
use PaymentServiceBundle\Domain\Factory\ModelFactory;
use PaymentServiceBundle\Domain\Model\PaymentRequest\InputModel\CreatePaymentRequestModel;
use PaymentServiceBundle\Domain\Service\PaymentRequestService;
use Symfony\Component\Uid\Uuid;

class Handler
{
    public function __construct(
        /** @var ModelFactory<CreatePaymentRequestModel> */
        private readonly ModelFactory $modelFactory,
        private readonly PaymentRequestService $paymentRequestService,
    ) {
    }

    public function create(RequestDTO $requestDTO): string
    {
        $uuid = Uuid::v1();

        $model = $this->modelFactory->makeModel(
            CreatePaymentRequestModel::class,
            $uuid,
            $requestDTO->userId,
            RequestTypeEnum::CreatePayment,
            RequestStatusEnum::Received,
            $requestDTO->amount,
            $requestDTO->purpose
        );

       $this->paymentRequestService->createPaymentRequest($model);

       return $uuid;
    }
}

