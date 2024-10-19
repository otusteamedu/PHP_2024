<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Priority;

class Event
{
    private ?int $id = null;
    private Priority $priority;
    private Name $name;
    private ConditionList $condition_list;

    public function __construct(
        Priority $priority,
        Name $name,
        ConditionList $condition_list
    )
    {
        $this->priority = $priority;
        $this->name = $name;
        $this->condition_list = $condition_list;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConditionList(): ConditionList
    {
        return $this->condition_list;
    }

    public function getPriority(): Priority
    {
        return $this->priority;
    }
    public function getName(): Name
    {
        return $this->name;
    }
}
