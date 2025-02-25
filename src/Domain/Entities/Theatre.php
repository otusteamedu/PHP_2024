<?php

declare(strict_types=1);

namespace Domain\Entities;

class Theatre
{
    public ?int $id = null;
    public string $title;
    public string $location;
    public int $capacity;
}
