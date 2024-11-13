<?php

declare(strict_types=1);

namespace App\Application;

class EventManager
{
    private $events = [];

    public function addEvent($eventName, $callback)
    {
        if (!isset($this->events[$eventName])) {
            $this->events[$eventName] = [];
        }
        $this->events[$eventName][] = $callback;
    }

    public function trigger($eventName, $data = null)
    {
        if (isset($this->events[$eventName])) {
            foreach ($this->events[$eventName] as $callback) {
                call_user_func($callback, $data);
            }
        }
    }
}
