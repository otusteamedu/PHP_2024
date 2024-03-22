<?php

declare(strict_types=1);

namespace Lrazumov\Hw14;

use Exception;

class App
{
    private string $mode;

    public function __construct(string $mode)
    {
        $this->mode = $mode;
    }

    public function run()
    {
        echo 'App run with mode: ' . $this->mode . PHP_EOL;
    }
}