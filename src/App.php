<?php

declare(strict_types=1);

namespace Afilipov\Hw12;

class App
{
    /**
     * @throws \RedisException
     */
    public function run(): string
    {
        $redisStorage = new RedisStorage(new RedisConfig());
        $eventHelper = new EventHelper();
        $eventService = new EventService($redisStorage, $eventHelper);
        $eventService->clearEvents();

        $event1 = new Event(1000, ['param1' => 1], '::event::');
        $event2 = new Event(2000, ['param1' => 2, 'param2' => 2], '::event::');
        $event3 = new Event(3000, ['param1' => 1, 'param2' => 2], '::event::');

        $eventService->addEvent($event1);
        $eventService->addEvent($event2);
        $eventService->addEvent($event3);

        $userRequest = new UserRequest(['param1' => 1, 'param2' => 2]);
        $result = $eventService->getEventByUserRequest($userRequest);

        $resultsFormatter = new ResultsFormatter();
        return $resultsFormatter->formatResults($result);
    }
}
