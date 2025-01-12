<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw11\Builders;

use Asyrovatkin\Hw11\Models\Event;

class EventBuilder
{
    public function build($eventArr): Event
    {
        $event = new Event();
        if (array_key_exists('id', $eventArr)) $event->setId($eventArr['id']);
        if (array_key_exists('event', $eventArr)) $event->setEvent($eventArr['event']);
        if (array_key_exists('priority', $eventArr)) $event->setPriority((int)$eventArr['priority']);
        if (array_key_exists('conditions', $eventArr)) {
            if (array_key_exists('param1', $eventArr['conditions'])) $event->setParam1(intval($eventArr['conditions']['param1']));
            if (array_key_exists('param2', $eventArr['conditions'])) $event->setParam2(intval($eventArr['conditions']['param2']));
        }

        return $event;
    }
}