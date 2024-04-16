<?php

declare(strict_types=1);

namespace AlexanderGladkov\Bookshop\Application;

use AlexanderGladkov\Bookshop\Application\Action\CreateIndexAction;
use AlexanderGladkov\Bookshop\Application\Action\SearchAction;
use AlexanderGladkov\Bookshop\Application\CLIService\CLIService;
use AlexanderGladkov\Bookshop\Config\ConfigFileReadException;
use AlexanderGladkov\Bookshop\Config\ConfigValidationException;
use Elastic\Elasticsearch\Exception\AuthenticationException;

class Application
{
    /**
     * @return void
     * @throws AuthenticationException
     * @throws ConfigFileReadException
     * @throws ConfigValidationException
     */
    public function run(): void
    {
        $config = new Config(__DIR__ . '/../../appFiles/app.ini');
        $input = (new CLIService())->getInput();
        $action = match ($input->getCommand()) {
            Command::CreateIndex => new CreateIndexAction($config),
            Command::Search => new SearchAction($config),
        };

        $response = $action->run($input->getArgs());
        echo $response->getContent();
    }
}
