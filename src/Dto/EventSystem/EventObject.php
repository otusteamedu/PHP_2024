<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Dto\EventSystem;

use Spatie\DataTransferObject\DataTransferObject;

class EventObject extends DataTransferObject
{
    public int $priority;
    public array $conditions;
    public Event $event;
}
