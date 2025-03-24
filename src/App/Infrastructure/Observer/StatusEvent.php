<?php

namespace App\Infrastructure\Observer;

use App\Application\Observer\Event;
use App\Domain\Enum\Status;

class StatusEvent implements Event
{
    public function __construct(public Status $status)
    {
    }
}