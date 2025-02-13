<?php

declare(strict_types=1);

namespace App\Handlers;

use SplFileInfo;

class FileHandler implements Handler
{
    private ?Handler $next = null;

    public function next(Handler $handler): void
    {
        $this->next = $handler;
    }

    public function handle(SplFileInfo $file): bool
    {
        return $file->getFilename()[0] !== '.' && (!$this->next || $this->next->handle($file));
    }
}