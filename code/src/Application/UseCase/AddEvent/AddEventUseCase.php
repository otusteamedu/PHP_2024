<?php

declare(strict_types=1);

namespace Viking311\Api\Application\UseCase\AddEvent;

use InvalidArgumentException;
use Viking311\Api\Application\Adapter\QueueAdapterInterface;
use Viking311\Api\Domain\Factory\EventFactoryInterface;
use Viking311\Api\Domain\Repository\EventRepositoryInterface;

readonly class AddEventUseCase
{
    public function __construct(
        private EventFactoryInterface $eventFactory,
        private QueueAdapterInterface $queue,
        private EventRepositoryInterface $eventRepository
    ) {
    }

    /**
     * @param AddEventRequest $request
     * @return AddEventResponse
     * @throws InvalidArgumentException
     */
    public function __invoke(AddEventRequest $request): AddEventResponse
    {
        $event = $this->eventFactory
            ->create(
                $request->name,
                $request->email,
                $request->eventDate,
                $request->address,
                $request->guest
            );
        $this->eventRepository->save($event);

        $message = json_encode([
            'id' => $event->getId(),
        ]);

        $this->queue->send($message);

        return new AddEventResponse(
            $event->getId()
        );
    }
}
