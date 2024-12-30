<?php

namespace App\Application\Handlers;

use App\Domain\HandlerInterface;
use SplFileInfo;

class SizeHandler implements HandlerInterface
{
    private ?HandlerInterface $next = null;
    private int $maxSize;

    public function __construct(int $maxSize)
    {
        $this->maxSize = $maxSize;
    }

    public function setNext(HandlerInterface $handler): void
    {
        $this->next = $handler;
    }

    public function handle(SplFileInfo $fileinfo): bool
    {
        if ($fileinfo->getSize() > $this->maxSize) {
            return false;
        }

        return !$this->next || $this->next->handle($fileinfo);
    }
}
