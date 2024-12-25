<?php

namespace PaymentServiceBundle\Controller\Amqp\Report\Create;

use DateTime;
use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestStatusEnum;
use PaymentServiceBundle\Application\RabbitMq\AbstractConsumer;
use PaymentServiceBundle\Domain\Factory\ModelFactory;
use PaymentServiceBundle\Domain\Model\Report\InputReportModel;
use PaymentServiceBundle\Domain\Service\ReportRequestService;

class Consumer extends AbstractConsumer
{
    public function __construct(
        /** @var ModelFactory<InputReportModel> */
        private readonly ModelFactory         $modelFactory,
        private readonly ReportRequestService $reportRequestService,
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
            InputReportModel::class,
            $message->uuid,
            $message->userId,
            $message->userEmail,
            RequestStatusEnum::Received,
            DateTime::createFromFormat('Y-m-d' , $message->periodBegin)->setTime(0,00),
            DateTime::createFromFormat('Y-m-d' , $message->periodEnd)->setTime(23,23, 59),
            null,
            $message->showDeleted ?? null,
        );

        $this->reportRequestService->createReportRequest($model);

        return self::MSG_ACK;
    }
}
