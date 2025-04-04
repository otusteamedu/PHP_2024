<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw15\Proxy;

use Asyrovatkin\Hw15\Strategy\StrategyResolver;

class RealSubject implements Subject
{
    public function filePrint(string $path): void
    {
        $extension = preg_replace('/^.*\.([^.]+)$/D', '$1', $path);
        $resolver = new StrategyResolver();
        $strategy = $resolver->getStrategy($extension);
        $content = file_get_contents($path);
        $strategy->print($content);
    }
}