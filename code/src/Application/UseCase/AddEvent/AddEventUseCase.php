<?php

declare(strict_types=1);

namespace Viking311\Queue\Application\UseCase\AddEvent;

use InvalidArgumentException;
use Viking311\Queue\Application\Adapter\QueueAdapterInterface;
use Viking311\Queue\Domain\Factory\EventFactoryInterface;

readonly class AddEventUseCase
{
    public function __construct(
        private EventFactoryInterface $eventFactory,
        private QueueAdapterInterface $queue
    ){
    }

    /**
     * @param AddEventRequest $request
     * @return void
     * @throws InvalidArgumentException
     */
    public function __invoke(AddEventRequest $request): void
    {
        $event = $this->eventFactory
            ->create(
                $request->name,
                $request->email,
                $request->eventDate,
                $request->address,
                $request->guest
            );
        $message = json_encode([
            'name' => $event->getName()->getValue(),
            'email' => $event->getEmail()->getVaule(),
            'eventDate' => $event->getEventDate()->getValue()->format('Y-d-m H:i'),
            'place' => $event->getPlace()->getValue(),
            'guest' => $event->getGuests()->getValue()
        ]);

        $this->queue->send($message);
    }
}
