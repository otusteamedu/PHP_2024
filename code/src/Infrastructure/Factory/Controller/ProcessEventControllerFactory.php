<?php

declare(strict_types=1);

namespace Viking311\Queue\Infrastructure\Factory\Controller;

use Exception;
use Viking311\Queue\Infrastructure\Controller\ProcessEventController;
use Viking311\Queue\Infrastructure\Factory\UseCase\ProcessEvent\ProcessEventUseCaseFactory;

class ProcessEventControllerFactory
{
    /**
     * @return ProcessEventController
     * @throws Exception
     */
    public static function createInstance(): ProcessEventController
    {
        $useCase  = ProcessEventUseCaseFactory::createInstance();

        return new ProcessEventController($useCase);
    }
}
