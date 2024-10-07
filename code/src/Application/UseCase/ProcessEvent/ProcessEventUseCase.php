<?php

declare(strict_types=1);

namespace Viking311\Queue\Application\UseCase\ProcessEvent;

use Exception;
use Viking311\Queue\Application\Adapter\QueueAdapterInterface;
use Viking311\Queue\Application\Notification\NotificationInterface;
use Viking311\Queue\Domain\Factory\EventFactoryInterface;

readonly class ProcessEventUseCase
{
    public function __construct(
        private QueueAdapterInterface $queue,
        private EventFactoryInterface $eventFactory,
        private NotificationInterface $notification
    ) {
    }

    /**
     * @return ProcessEventResponse
     * @throws Exception
     */
    public function __invoke(): ProcessEventResponse
    {
        $msg = $this->queue->receive();

        $data = json_decode($msg);
        if (!is_object($data)) {
            throw  new Exception('Bad data');
        }

        $event = $this->eventFactory->create(
            $data->name ?? '',
            $data->email ?? '',
            $data->eventDate ?? '',
            $data->place ?? '',
            isset($data->guest) ? (int) $data->guest : 0
        );

        $this->notification->send($event);

        return new ProcessEventResponse($msg);
    }
}
