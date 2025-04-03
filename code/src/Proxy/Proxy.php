<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw15\Proxy;

use Asyrovatkin\Hw15\Strategy\StrategyResolver;

class Proxy implements Subject
{
    private array $extensionsToPrint;
    public function __construct(array $extensionsToPrint)
    {
        $this->extensionsToPrint = $extensionsToPrint;
    }

    public function filePrint(string $path): void
    {
        $extension = preg_replace('/^.*\.([^.]+)$/D', '$1', $path);
        if (in_array($extension, $this->extensionsToPrint)) {
            (new RealSubject())->filePrint($path);
        }
    }

}