<?php

declare(strict_types=1);

namespace Dsergei\Hw12;

use Dsergei\Hw12\event\Event;
use Dsergei\Hw12\event\EventService;
use Dsergei\Hw12\redis\RedisResponse;
use Dsergei\Hw12\redis\RedisStorage;

class App
{
    public function run(): string
    {
        $storage = new RedisStorage();
        $eventService = new EventService($storage);
        $eventService->clearEvents();

        $event1 = new Event(1000, ['param1' => 1], '::event::');
        $event2 = new Event(2000, ['param1' => 2, 'param2' => 2], '::event::');
        $event3 = new Event(3000, ['param1' => 1, 'param2' => 2], '::event::');

        $eventService->addEvent($event1);
        $eventService->addEvent($event2);
        $eventService->addEvent($event3);

        $response = new RedisResponse($eventService->getEventByUserRequest());
        return $response->getResponse();
    }
}