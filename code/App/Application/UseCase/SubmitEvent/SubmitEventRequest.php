<?php

declare(strict_types=1);

namespace App\Application\UseCase\SubmitEvent;

class SubmitEventRequest
{
    public int $priority;
    public string $name;
    public array $condition_list;
    public function __construct(
        int $priority,
        string $name,
        array $condition_list
    )
    {
        $this->priority = $priority;
        $this->name = $name;
        $this->condition_list = $condition_list;
    }
}