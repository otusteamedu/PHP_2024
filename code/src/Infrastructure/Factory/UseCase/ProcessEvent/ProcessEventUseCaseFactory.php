<?php

declare(strict_types=1);

namespace Viking311\Queue\Infrastructure\Factory\UseCase\ProcessEvent;

use Exception;
use Viking311\Queue\Application\UseCase\ProcessEvent\ProcessEventUseCase;
use Viking311\Queue\Infrastructure\Factory\Adapter\RabbitMqAdapterFactory;
use Viking311\Queue\Infrastructure\Factory\Event\EventFactory;
use Viking311\Queue\Infrastructure\Factory\Notification\MailFactory;

class ProcessEventUseCaseFactory
{
    /**
     * @return ProcessEventUseCase
     * @throws Exception
     */
    public static function createInstance(): ProcessEventUseCase
    {
        $queueAdapter = RabbitMqAdapterFactory::createInstance();

        $factory = new EventFactory();

        $mail = MailFactory::createInstance();

        return new ProcessEventUseCase(
            $queueAdapter,
            $factory,
            $mail
        );
    }
}
