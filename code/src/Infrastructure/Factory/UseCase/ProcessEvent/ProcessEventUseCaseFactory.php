<?php

declare(strict_types=1);

namespace Viking311\Queue\Infrastructure\Factory\UseCase\ProcessEvent;

use Exception;
use Viking311\Queue\Application\UseCase\ProcessEvent\ProcessEventUseCase;
use Viking311\Queue\Infrastructure\Factory\Adapter\RabbitMqAdapterFactory;

class ProcessEventUseCaseFactory
{
    /**
     * @return ProcessEventUseCase
     * @throws Exception
     */
    public static function createInstance(): ProcessEventUseCase
    {
        $queueAdapter = RabbitMqAdapterFactory::createInstance();

        return new ProcessEventUseCase($queueAdapter);
    }
}
