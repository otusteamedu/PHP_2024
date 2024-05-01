<?php

declare(strict_types=1);

namespace AShutov\Hw15;

use AShutov\Hw15\Requests\AddEventRequest;
use AShutov\Hw15\Requests\GetEventRequest;
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
            case 'add':
                $request = new AddEventRequest();
                return $eventsService->addEvent($request);
            case 'get':
                $request = new GetEventRequest();
                return $eventsService->getEvent($request);
            case 'removeAll':
                return $eventsService->removeAllEvents();
            default:
                throw new Exception("Укажите тип реквеста");
        }
    }

    private function getAppType(): string
    {
        return $_SERVER['argv'][1] ?? '';
    }
}
