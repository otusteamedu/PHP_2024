<?php

declare(strict_types=1);

namespace Lrazumov\Hw5;

class App
{
    private string $mode;

    function __construct(string $mode) {
        $this->mode = $mode;
    }

    public function run()
    {
        print $this->mode;
    }
}
