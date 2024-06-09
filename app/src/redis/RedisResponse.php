<?php

namespace Dsergei\Hw12\redis;

use Dsergei\Hw12\event\Event;

class RedisResponse
{

    public function __construct(
        private ?Event $event
    ) {
    }

    public function getResponse(): string
    {
        if ($this->event === null) {
            return "Ничего не найдено.\n";
        }

        $conditions = json_encode($this->event->conditions);
        return "event: {$this->event->event}, conditions: {$conditions}, priority: {$this->event->priority}\n";
    }
}
