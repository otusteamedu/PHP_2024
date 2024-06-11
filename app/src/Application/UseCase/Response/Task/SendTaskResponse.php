<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response\Task;

class SendTaskResponse
{
    public function __construct(private int $id)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
