<?php

declare(strict_types=1);

namespace Viking311\Api\Infrastructure\Factory\Command;

use Exception;
use Viking311\Api\Infrastructure\Command\ProcessEventCommand;
use Viking311\Api\Infrastructure\Factory\UseCase\ProcessEvent\ProcessEventUseCaseFactory;

class ProcessEventCommandFactory
{
    /**
     * @return ProcessEventCommand
     * @throws Exception
     */
    public static function createInstance(): ProcessEventCommand
    {
        $useCase  = ProcessEventUseCaseFactory::createInstance();

        return new ProcessEventCommand($useCase);
    }
}
