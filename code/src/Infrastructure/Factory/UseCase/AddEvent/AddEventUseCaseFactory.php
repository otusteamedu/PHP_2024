<?php

declare(strict_types=1);

namespace Viking311\Queue\Infrastructure\Factory\UseCase\AddEvent;

use Exception;
use Viking311\Queue\Application\UseCase\AddEvent\AddEventUseCase;
use Viking311\Queue\Infrastructure\Factory\Adapter\RabbitMqAdapterFactory;
use Viking311\Queue\Infrastructure\Factory\Event\EventFactory;

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

        return new AddEventUseCase(
            $eventFactory,
            $queueAdapter
        );
    }
}
