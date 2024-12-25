<?php

namespace PaymentServiceBundle\Controller\Amqp\Payment\Delete;

use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestStatusEnum;
use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestTypeEnum;
use PaymentServiceBundle\Application\RabbitMq\AbstractConsumer;
use PaymentServiceBundle\Domain\Factory\ModelFactory;
use PaymentServiceBundle\Domain\Model\PaymentRequest\InputModel\DeletePaymentRequestModel;
use PaymentServiceBundle\Domain\Service\PaymentRequestService;

class Consumer extends AbstractConsumer
{
    public function __construct(
        /** @var ModelFactory<DeletePaymentRequestModel> */
        private readonly ModelFactory $modelFactory,
        private readonly PaymentRequestService $paymentRequestService,
    ) {
    }

    protected function getMessageClass(): string
    {
        return Message::class;
    }

    /**
     * @param Message $message
     */
    protected function handle($message): int
    {
        $userId = $this->paymentRequestService->getUserIdByRequestUuid($message->parentUuid);

        $model = $this->modelFactory->makeModel(
            DeletePaymentRequestModel::class,
            $message->uuid,
            $message->parentUuid,
            $userId ?? 0,
            RequestTypeEnum::DeletePayment,
            RequestStatusEnum::Received,
        );

        $this->paymentRequestService->deletePaymentByRequest($model);

        return self::MSG_ACK;
    }
}
