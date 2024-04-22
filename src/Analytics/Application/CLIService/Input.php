<?php

declare(strict_types=1);

namespace AlexanderGladkov\Analytics\Application\CLIService;

use AlexanderGladkov\Analytics\Application\Command;

class Input
{
    public function __construct(
        private readonly Command $command,
        private readonly array $args = []
    ) {
    }

    public function getCommand(): Command
    {
        return $this->command;
    }

    public function getArgs(): array
    {
        return $this->args;
    }
}
