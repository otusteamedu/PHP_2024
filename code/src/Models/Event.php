<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw11\Models;

class Event
{
    private ?int $id = null;
    private ?int $priority = null;
    private ?int $param1 = null;
    private ?int $param2 = null;
    private ?string $event = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(?int $priority): void
    {
        $this->priority = $priority;
    }

    public function getParam1(): ?int
    {
        return $this->param1;
    }

    public function setParam1(?int $param1): void
    {
        $this->param1 = $param1;
    }

    public function getParam2(): ?int
    {
        return $this->param2;
    }

    public function setParam2(?int $param2): void
    {
        $this->param2 = $param2;
    }

    public function getEvent(): ?string
    {
        return $this->event;
    }

    public function setEvent(?string $event): void
    {
        $this->event = $event;
    }

    public function toArray(): array
    {
        $eventArr = [];
        if (!is_null($this->priority)) $eventArr['priority'] = $this->priority;
        if (!is_null($this->param1)) $eventArr['param1'] = $this->param1;
        if (!is_null($this->param2)) $eventArr['param2'] = $this->param2;
        if (!is_null($this->event)) $eventArr['event'] = $this->event;
        return $eventArr;
    }


}