<?php
namespace AgapitovAlexandr\OtusHomework;

class Event
{
    public int $priority;
    public array $conditions;
    public string $event;

    public function __construct(int $priority, array $conditions, string $event)
    {
        $this->priority = $priority;
        $this->conditions = $conditions;
        $this->event = $event;
    }
}