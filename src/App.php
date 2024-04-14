<?php

namespace AKornienko\Php2024;

use AKornienko\Php2024\requests\AddEventRequest;
use AKornienko\Php2024\requests\GetEventRequest;
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
        $eventsService = new EventsService($config);

        switch ($this->getAppType()) {
            case 'post':
                $request = new AddEventRequest();
                return $eventsService->addEvent($request);
            case 'get':
                $request = new GetEventRequest();
                return $eventsService->getEvent($request);
            case 'delete':
                return $eventsService->removeAllEvents();
            default:
                throw new Exception("Wrong app request");
        }
    }

    private function getAppType(): string
    {
        return $_SERVER['argv'][1] ?? '';
    }
}
