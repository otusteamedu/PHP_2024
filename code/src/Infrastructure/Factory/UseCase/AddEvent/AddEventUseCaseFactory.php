<?php

declare(strict_types=1);

namespace Viking311\Api\Infrastructure\Factory\UseCase\AddEvent;

use Exception;
use Viking311\Api\Application\UseCase\AddEvent\AddEventUseCase;
use Viking311\Api\Infrastructure\Factory\Adapter\RabbitMqAdapterFactory;
use Viking311\Api\Infrastructure\Factory\Event\EventFactory;
use Viking311\Api\Infrastructure\Factory\Repository\EventRepositoryFactory;

class AddEventUseCaseFactory
{
    /**
     * @return AddEventUseCase
     * @throws Exception
     */
    public static function createInstance(): AddEventUseCase
    {
        $queueAdapter = RabbitMqAdapterFactory::createInstance();
        $eventFactory = new EventFactory();
        $eventRepository = EventRepositoryFactory::createInstance();

        return new AddEventUseCase(
            $eventFactory,
            $queueAdapter,
            $eventRepository
        );
    }
}
