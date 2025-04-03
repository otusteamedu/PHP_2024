<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw15\Proxy;

interface Subject
{
    public function filePrint(string $path): void;
}