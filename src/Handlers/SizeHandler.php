<?php

declare(strict_types=1);

namespace App\Handlers;

use SplFileInfo;

class SizeHandler implements Handler
{
    private ?Handler $next = null;
    private int $maxSize;

    public function __construct(int $maxSize)
    {
        $this->maxSize = $maxSize;
    }

    public function next(Handler $handler): void
    {
        $this->next = $handler;
    }

    public function handle(SplFileInfo $file): bool
    {
        return $file->getSize() <= $this->maxSize && (!$this->next || $this->next->handle($file));
    }
}