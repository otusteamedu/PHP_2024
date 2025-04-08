<?php

namespace App\Application\UseCase\Consume;

use App\Application\Consumer\ConsumerInterface;
use App\Application\LeadHandler\LeadHandlerInterface;
use App\Domain\Entity\Lead;
use App\Domain\Repository\LeadRepositoryInterface;
use PhpAmqpLib\Message\AMQPMessage;

readonly class ConsumeUseCase
{
    public function __construct(
        private ConsumerInterface $consumer,
        private LeadRepositoryInterface $leadRepository,
        private LeadHandlerInterface $leadHandler,
    )
    {
    }

    public function __invoke(): void
    {
        // создаем коллбэк, который будет обрабатывать заявки из очереди
        $callback = function (AMQPMessage $msg) {
            // декодируем полученное сообщение
            $decodedMessage = json_decode($msg->getBody(), true);

            // получаем из полученного сообщения id заявки
            $leadId = $decodedMessage['leadId'];

            // получаем заявку
            $lead = $this->leadRepository->findById($leadId);

            // Обрабатываем заявку и записываем результат обработки и статус заявки
            try {
                $leadHandlerResult = $this->leadHandler->handle($lead);
                $lead->setResult(json_encode($leadHandlerResult, JSON_UNESCAPED_UNICODE));
                $lead->setStatus(Lead::STATUS_SUCCESS);
                $this->leadRepository->update($lead);
            } catch (\Throwable $e) {
                $lead->setStatus(Lead::STATUS_ERROR);
                $this->leadRepository->update($lead);
            }

        };

        // запускаем консьюмер
        $this->consumer->listenToQueue($callback);
    }

}
