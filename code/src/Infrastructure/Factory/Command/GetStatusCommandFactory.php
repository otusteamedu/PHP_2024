<?php

declare(strict_types=1);

namespace Viking311\Api\Infrastructure\Factory\Command;

use Viking311\Api\Infrastructure\Command\GetStatusCommand;
use Viking311\Api\Infrastructure\Factory\UseCase\GetStatus\GetStatusUseCaseFactory;

class GetStatusCommandFactory
{
    public static function createInstance(): GetStatusCommand
    {
        $useCase = GetStatusUseCaseFactory::createInstance();

        return new GetStatusCommand($useCase);
    }
}
