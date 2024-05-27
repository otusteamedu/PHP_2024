<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Web\Application;

use Slim\App;

class MiddlewareInitialization
{
    public function __construct(private App $app)
    {
    }

    public function perform(): void
    {
        $container = $this->app->getContainer();

        $slimSettings = $container->get('settings')['slim'];
        $this->app->addErrorMiddleware(
            $slimSettings['displayErrorDetails'],
            $slimSettings['logErrors'],
            $slimSettings['logErrorDetails']
        );

        $this->app->addBodyParsingMiddleware();
    }
}
