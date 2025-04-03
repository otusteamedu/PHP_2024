<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw15\Composite;

use Asyrovatkin\Hw15\Proxy\Proxy;

abstract class Component
{
    protected string $path;
    protected array $extensionsToPrint;
    protected float $size = 0;

    public function __construct($path, $extensionsToPrint)
    {
        $this->path = $path;
        $this->extensionsToPrint = $extensionsToPrint;
    }

    public function display(): void
    {
        $name = preg_replace('/^.*\/([^\/]+)$/D', '$1', $this->path);
        $cntPad = substr_count($this->path, '/');
        print str_pad('', $cntPad * 2, ' ') . $name . ' ' . round($this->size, 3) . ' kb' . PHP_EOL;
    }

    public function setSize(float $size): void
    {
        $this->size = $size;
    }

    public function getSize(): float
    {
        return $this->size;
    }

    protected function print($path): void
    {
        $proxy = new Proxy($this->extensionsToPrint);
        $proxy->filePrint($path);
    }
}