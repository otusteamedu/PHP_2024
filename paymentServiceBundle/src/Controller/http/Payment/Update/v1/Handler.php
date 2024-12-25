<?php

namespace PaymentServiceBundle\Controller\http\Payment\Update\v1;

use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestStatusEnum;
use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestTypeEnum;
use PaymentServiceBundle\Domain\Entity\Request;
use PaymentServiceBundle\Domain\Factory\ModelFactory;
use PaymentServiceBundle\Domain\Model\PaymentRequest\InputModel\DeletePaymentRequestModel;
use PaymentServiceBundle\Domain\Model\PaymentRequest\InputModel\UpdatePaymentRequestModel;
use PaymentServiceBundle\Domain\Service\PaymentRequestService;
use Symfony\Component\Uid\Uuid;

class Handler
{
    public function __construct(
        /** @var ModelFactory<DeletePaymentRequestModel> */
        private readonly ModelFactory $modelFactory,
        private readonly PaymentRequestService $paymentRequestService,
    ) {
    }

    public function update(?Request $request, RequestDTO $requestDTO): string|bool
    {
        if ($request === null) {
            return false;
        }

        $uuid = Uuid::v1();

        $model = $this->modelFactory->makeModel(
            UpdatePaymentRequestModel::class,
            $uuid,
            $request->getUuid(),
            $request->getUserId(),
            RequestTypeEnum::UpdatePayment,
            RequestStatusEnum::Received,
            $requestDTO->amount ?? null,
            $requestDTO->purpose ?? null
        );

        $this->paymentRequestService->updatePaymentByRequest($model);

        return $uuid;
    }
}
