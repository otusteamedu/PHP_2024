<?php

declare(strict_types=1);

namespace App\Domain\File;

interface FileSystemInterface
{
    public function dump(string $path, string $content): void;
}
