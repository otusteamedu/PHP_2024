<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Collection\ConditionCollection;
use App\Domain\ValueObject\Priority;
use App\Domain\ValueObject\Uid;

class Event
{
    protected Uid $uid;

    public function setUid(Uid $uid): void
    {
        $this->uid = $uid;
    }
    public function __construct(protected Priority $priority, protected ConditionCollection $conditions)
    {
    }

    public function getUid(): Uid
    {
        return $this->uid;
    }

    public function getPriority(): Priority
    {
        return $this->priority;
    }

    public function getConditions(): ConditionCollection
    {
        return $this->conditions;
    }
}
