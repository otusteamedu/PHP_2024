<?php

namespace App\Console;

readonly class Input
{
    public ?string $file;

    public ?string $action;

    public ?array $arguments;

    public function __construct(array $argv)
    {
        $this->file = array_shift($argv);

        $this->action = array_shift($argv);

        $this->arguments = $argv;
    }
}