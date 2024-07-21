<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Application\ResponseDTO\ClearAllResponse;
use App\Domain\Collection\ConditionCollection;
use App\Domain\Entity\Event;
use App\Domain\ValueObject\Condition;

interface IRepository
{
    public function add(Event $event): Event;
    public function findEvent(ConditionCollection $conditionCollection): ?Event;
    public function clearAll(): ClearAllResponse;
}
