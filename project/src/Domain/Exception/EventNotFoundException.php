<?php

declare(strict_types=1);

namespace SFadeev\Hw12\Domain\Exception;

class EventNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('Event not found.');
    }
}
