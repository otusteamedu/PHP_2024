<?php

declare(strict_types=1);

namespace Dsergei\Hw12;

use Dsergei\Hw12\console\ConsoleParameters;
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
        $args = new ConsoleParameters();

        return $eventService->run($args);
    }
}
