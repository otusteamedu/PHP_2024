<?php

declare(strict_types=1);

namespace Dsergei\Hw12\event;

use Dsergei\Hw12\console\ConsoleParameters;
use Dsergei\Hw12\redis\RedisResponse;

readonly class EventService
{
    private EventHelper $helper;

    public function __construct(
        private EventStorage $storage
    ) {
        $this->helper = new EventHelper();
    }

    private function addEvent(Event $event): void
    {
        $this->storage->addEvent($event);
    }

    private function clearEvents(): void
    {
        $this->storage->clearEvents();
    }

    private function getEventByUserRequest(ConsoleParameters $params): ?Event
    {
        $events = $this->storage->getEvents();
        if (empty($events)) {
            return null;
        }

        $eventByUserConditions = null;

        foreach ($events as $event) {
            if ($this->helper->checkConditions($event, $params)) {
                $eventByUserConditions = $event;
                break;
            }
        }

        return $eventByUserConditions;
    }

    private function clear()
    {
        $this->clearEvents();
        return 'OK';
    }

    private function add(array $params)
    {
        $priority = 1;
        if(isset($params['priority'])) {
            $priority = $params['priority'];
            unset($params['priority']);
        }
        $event = new Event($priority, $params, '::event::');
        $this->addEvent($event);

        return 'OK';
    }

    private function get(ConsoleParameters $params)
    {
        $response = new RedisResponse($this->getEventByUserRequest($params));
        return $response->getResponse();
    }

    public function run(ConsoleParameters $params)
    {
        if($params->command == 'clear') {
            return $this->clear();
        }

        if($params->command == 'add') {
            return $this->add($params->params);
        }

        if($params->command == 'get') {
            return $this->get($params);
        }
    }
}
