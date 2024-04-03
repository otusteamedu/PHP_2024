<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Dto\EventSystem;

use Spatie\DataTransferObject\DataTransferObject;

class Event extends DataTransferObject
{
    public string $name;
}
