<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw15;

use Asyrovatkin\Hw15\Composite\Composite;

class Main
{
    public function process(string $path, array $extensionsToPrint): void
    {
        $root = new Composite($path, $extensionsToPrint);
        $root->scan();
        $root->display();
    }
}