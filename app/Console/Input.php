<?php

namespace App\Console;

class Input
{
    public ?string $file;

    public ?string $action;

    public ?string $template;

    public ?string $title;

    public ?int $price;

    public function __construct(array $argv)
    {
        $this->file = array_shift($argv);

        $this->action = array_shift($argv);

        $this->template = array_shift($argv);

        $this->title = array_shift($argv);

        $this->price = array_shift($argv);
    }
}
