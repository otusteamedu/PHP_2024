<?php

namespace Ahar\Hw12;

use Ahar\Hw12\storage\RedisConfig;
use Ahar\Hw12\storage\RedisStorage;

class Application
{
    public function run()
    {
        $storage = new RedisStorage(new RedisConfig());
        $service = new EventService($storage);
        $service->clear(Event::KEY_EVENT);

        $service->addEvent(Event::KEY_EVENT, new Event(1000, ['param1' => 1], '::event::'));
        $service->addEvent(Event::KEY_EVENT, new Event(2000, ['param1' => 2, 'param2' => 2], '::event::'));
        $service->addEvent(Event::KEY_EVENT, new Event(3000, ['param1' => 1, 'param2' => 2], '::event::'));

        $event = $service->getEvent(Event::KEY_EVENT, ['param1' => 1, 'param2' => 2]);

        if ($event === null) {
            return 'Ничего не найдено!';
        }

        return json_encode($event, JSON_THROW_ON_ERROR);
    }
}
