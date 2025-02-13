<?php

declare(strict_types=1);

namespace App\Handlers;

use SplFileInfo;

interface Handler
{
    public function next(Handler $handler): void;

    public function handle(SplFileInfo $file): bool;
}
