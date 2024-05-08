<?php

namespace AKornienko\Php2024\Application\CreateEvent\request;

use AKornienko\Php2024\Domain\Conditions;
use AKornienko\Php2024\Domain\Event;
use AKornienko\Php2024\Domain\Priority;
use Exception;

class CreateEventRequest
{
    public readonly Priority $priority;
    public readonly Event $event;
    public readonly Conditions $conditions;
    private array $request;

    /**
     * @throws Exception
     */
    public function __construct(string $request)
    {
        $this->request = json_decode($request, true);
        if (!$this->request) {
            throw new \InvalidArgumentException('invalid user request');
        }

        $this->conditions = new Conditions($this->request['conditions']);
        $this->priority = new Priority($this->request['priority']);
        $this->event = new Event($this->request['event']['name'], $this->request['event']['description']);
    }
}
