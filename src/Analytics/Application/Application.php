<?php

declare(strict_types=1);

namespace AlexanderGladkov\Analytics\Application;

use AlexanderGladkov\Analytics\Application\Action\BaseAction;
use AlexanderGladkov\Analytics\Application\Action\AddAction;
use AlexanderGladkov\Analytics\Application\Action\GetAction;
use AlexanderGladkov\Analytics\Application\Action\FillTestDataAction;
use AlexanderGladkov\Analytics\Application\Action\DeleteAllAction;
use AlexanderGladkov\Analytics\Application\CLIService\CLIService;
use AlexanderGladkov\Analytics\Application\CLIService\Input;
use AlexanderGladkov\Analytics\Config\ConfigFileReadException;
use AlexanderGladkov\Analytics\Config\ConfigValidationException;
use AlexanderGladkov\Analytics\Redis\RedisFactory;
use AlexanderGladkov\Analytics\Repository\RedisEventRepository;
use LogicException;

class Application
{
    private readonly Config $config;

    /**
     * @throws ConfigFileReadException
     * @throws ConfigValidationException
     */
    public function __construct()
    {
        $this->config = new Config(__DIR__ . '/../../appFiles/app.ini');
    }

    public function run(): void
    {
        $input = (new CLIService())->getInput();
        $action = $this->getAction($input);
        $response = $action->run($input->getArgs());
        echo $response->getContent();
    }

    private function getAction(Input $input): BaseAction
    {
        $repository = $this->getEventRepository();
        return match ($input->getCommand()) {
            Command::Add => new AddAction($repository),
            Command::Get => new GetAction($repository),
            Command::FillTestData => new FillTestDataAction($repository),
            Command::DeleteAll => new DeleteAllAction($repository),
            default => throw new LogicException(),
        };
    }

    private function getEventRepository(): RedisEventRepository
    {
        $redis = (new RedisFactory())->createWithNoAuthentication(
            $this->config->getHost(),
            $this->config->getPort()
        );

        return new RedisEventRepository($redis);
    }
}
