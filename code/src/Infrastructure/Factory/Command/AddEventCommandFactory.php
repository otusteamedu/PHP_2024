<?php

declare(strict_types=1);

namespace Viking311\Api\Infrastructure\Factory\Command;

use Exception;
use Viking311\Api\Infrastructure\Factory\UseCase\AddEvent\AddEventUseCaseFactory;
use Viking311\Api\Infrastructure\Command\AddEventCommand;

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
