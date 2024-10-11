<?php

declare(strict_types=1);

namespace Viking311\Api\Infrastructure\Factory\UseCase\ProcessEvent;

use Exception;
use Viking311\Api\Application\UseCase\ProcessEvent\ProcessEventUseCase;
use Viking311\Api\Infrastructure\Factory\Adapter\RabbitMqAdapterFactory;
use Viking311\Api\Infrastructure\Factory\Repository\EventRepositoryFactory;

class ProcessEventUseCaseFactory
{
    /**
     * @return ProcessEventUseCase
     * @throws Exception
     */
    public static function createInstance(): ProcessEventUseCase
    {
        $queueAdapter = RabbitMqAdapterFactory::createInstance();

        $repository = EventRepositoryFactory::createInstance();

        return new ProcessEventUseCase(
            $queueAdapter,
            $repository
        );
    }
}
