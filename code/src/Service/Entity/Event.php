<?php

declare(strict_types=1);

namespace App\Service\Entity;

class Event
{
    private string $title;
    private int    $priority;
    private array $params;


    public function getId(): string {
        return md5(serialize($this));
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Event
    {
        $this->title = $title;
        return $this;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): Event
    {
        $this->priority = $priority;
        return $this;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param EventParam[] $params
     */
    public function setParams(array $params): Event
    {
        $this->params = $params;
        return $this;
    }

    public function addEventParam(EventParam $eventParam): Event {
        if(!in_array($eventParam, $this->params)) {
            $this->params[] = $eventParam;
        }

        return $this;
    }

    public function removeEventParam(EventParam $eventParam): Event {
        foreach ($this->params as $key => $item) {
            if($eventParam === $item) {
                unset($this->params[$key]);
            }
        }

        return $this;
    }

    public function __serialize(): array
    {
        array_multisort($this->params);
        return [
            'title' => $this->title,
            'priority' => $this->priority,
            'params' => $this->params
        ];
    }

}