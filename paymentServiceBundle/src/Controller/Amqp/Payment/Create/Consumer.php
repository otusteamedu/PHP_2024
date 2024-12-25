<?php

namespace PaymentServiceBundle\Controller\Amqp\Payment\Create;

use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestStatusEnum;
use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestTypeEnum;
use PaymentServiceBundle\Application\RabbitMq\AbstractConsumer;
use PaymentServiceBundle\Domain\Factory\ModelFactory;
use PaymentServiceBundle\Domain\Model\PaymentRequest\InputModel\CreatePaymentRequestModel;
use PaymentServiceBundle\Domain\Service\PaymentRequestService;

class Consumer extends AbstractConsumer
{
    public function __construct(
        /** @var ModelFactory<CreatePaymentRequestModel> */
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
        $model = $this->modelFactory->makeModel(
            CreatePaymentRequestModel::class,
            $message->uuid,
            $message->userId,
            RequestTypeEnum::CreatePayment,
            RequestStatusEnum::Received,
            $message->amount,
            $message->purpose
        );

        $this->paymentRequestService->createPaymentRequest($model);

        return self::MSG_ACK;
    }
}
