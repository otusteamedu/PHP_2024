<?php

namespace AKornienko\Php2024;

use AKornienko\Php2024\Application\CreateEvent\EventCreator;
use AKornienko\Php2024\Application\CreateEvent\request\CreateEventRequest;
use AKornienko\Php2024\Application\DeleteEvents\EventsDeleter;
use AKornienko\Php2024\Application\EventsService;
use AKornienko\Php2024\Application\GetEvents\EventsFinder;
use AKornienko\Php2024\Application\GetEvents\request\GetEventsRequest;
use AKornienko\Php2024\Infrastructure\Config;
use AKornienko\Php2024\Infrastructure\RedisClient;
use Exception;

class App
{
    /**
     * @throws Exception
     * @throws \RedisException
     */
    public function run(): string
    {
        $config = new Config();
        $redisClient = new RedisClient($config);
        $eventsService = new EventsService($redisClient);

        switch ($this->getAppType()) {
            case 'post':
                $request = new CreateEventRequest($this->getUserRequestParams());
                return (new EventCreator($eventsService))->__invoke($request);
            case 'get':
                $request = new GetEventsRequest($this->getUserRequestParams());
                return (new EventsFinder($eventsService))->__invoke($request);
            case 'delete':
                return (new EventsDeleter($eventsService))->__invoke();
            default:
                throw new Exception("Wrong app request");
        }
    }

    private function getAppType(): string
    {
        return $_SERVER['argv'][1] ?? '';
    }

    private function getUserRequestParams(): string
    {
        return $_SERVER['argv'][2] ?? '';
    }
}
