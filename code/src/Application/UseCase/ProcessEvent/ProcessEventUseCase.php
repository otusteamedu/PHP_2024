<?php

declare(strict_types=1);

namespace Viking311\Api\Application\UseCase\ProcessEvent;

use Exception;
use Viking311\Api\Application\Adapter\QueueAdapterInterface;
use Viking311\Api\Domain\Entity\Event;
use Viking311\Api\Domain\Repository\EventRepositoryInterface;

readonly class ProcessEventUseCase
{
    public function __construct(
        private QueueAdapterInterface $queue,
        private EventRepositoryInterface $eventRepository
    ) {
    }

    /**
     * @return ProcessEventResponse
     * @throws Exception
     */
    public function __invoke(): ProcessEventResponse
    {
        $msg = $this->queue->receive();

        $data = json_decode($msg, true);
        if (!is_array($data)) {
            throw  new Exception('Bad data');
        }

        if (!array_key_exists('id', $data)) {
            throw  new Exception('Id not found');
        }

        $event = $this->eventRepository->getById(
            $data['id']
        );

        $newEvent = new Event(
            $event->getName(),
            $event->getEmail(),
            $event->getEventDate(),
            $event->getPlace(),
            $event->getGuests(),
            'processed',
            $event->getId()
        );

        $this->eventRepository->save($newEvent);

        return new ProcessEventResponse($msg);
    }
}
