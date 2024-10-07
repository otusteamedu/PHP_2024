<?php

declare(strict_types=1);

namespace Viking311\Queue\Infrastructure\Factory\Controller;

use Viking311\Queue\Infrastructure\Factory\UseCase\AddEvent\AddEventUseCaseFactory;
use Viking311\Queue\Infrastructure\Controller\AddEventController;

class AddEventControllerFactory
{
    /**
     * @return AddEventController
     */
    public static function createInstance(): AddEventController
    {
        $useCase = AddEventUseCaseFactory::createInstance();

        return new AddEventController($useCase);
    }
}
