<?php

namespace PaymentServiceBundle\Controller\http\Payment\Delete\v1;

use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestStatusEnum;
use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestTypeEnum;
use PaymentServiceBundle\Domain\Entity\Request;
use PaymentServiceBundle\Domain\Factory\ModelFactory;
use PaymentServiceBundle\Domain\Model\PaymentRequest\InputModel\DeletePaymentRequestModel;
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

    public function delete(?Request $request): string|bool
    {
        if ($request === null) {
            return false;
        }

        $uuid = Uuid::v1();

        $model = $this->modelFactory->makeModel(
            DeletePaymentRequestModel::class,
            $uuid,
            $request->getUuid(),
            $request->getUserId(),
            RequestTypeEnum::DeletePayment,
            RequestStatusEnum::Received,
        );

        $this->paymentRequestService->deletePaymentByRequest($model);

        return $uuid;
    }
}
