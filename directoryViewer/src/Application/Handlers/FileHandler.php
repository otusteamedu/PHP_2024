<?php

namespace App\Application\Handlers;

use App\Domain\HandlerInterface;
use SplFileInfo;

class FileHandler implements HandlerInterface
{
    private ?HandlerInterface $next = null;

    public function setNext(HandlerInterface $handler): void
    {
        $this->next = $handler;
    }

    public function handle(SplFileInfo $fileinfo): bool
    {
        if ($fileinfo->getFilename()[0] === '.') {
            return false;
        }

        return !$this->next || $this->next->handle($fileinfo);
    }
}
