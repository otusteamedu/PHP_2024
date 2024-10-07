<?php

declare(strict_types=1);

namespace Viking311\Queue\Infrastructure\Factory\Command;

use Exception;
use Viking311\Queue\Infrastructure\Factory\UseCase\AddEvent\AddEventUseCaseFactory;
use Viking311\Queue\Infrastructure\Command\AddEventCommand;

class AddEventCommandFactory
{
    /**
     * @return AddEventCommand
     * @throws Exception
     */
    public static function createInstance(): AddEventCommand
    {
        $useCase = AddEventUseCaseFactory::createInstance();

        return new AddEventCommand($useCase);
    }
}
