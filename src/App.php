<?php

declare(strict_types=1);

namespace AShutov\Hw15;

use AShutov\Hw15\Requests\AddEventRequest;
use AShutov\Hw15\Requests\GetEventRequest;
use Exception;
use RedisException;

class App
{
    /**
     * @throws Exception
     * @throws RedisException
     */
    public function run(): string
    {
        $config = new Config();
        $eventsService = new EventsService($config);

        switch ($this->getType()) {
            case 'add':
                $request = new AddEventRequest();
                return $eventsService->addEvent($request);
            case 'get':
                $request = new GetEventRequest();
                return $eventsService->getEvent($request);
            case 'removeAll':
                return $eventsService->removeAllEvents();
            default:
                throw new Exception("Неверный тип запроса");
        }
    }

    private function getType(): string
    {
        return $_SERVER['argv'][1] ?? '';
    }
}
