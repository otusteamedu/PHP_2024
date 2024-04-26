<?php

declare(strict_types=1);

namespace App\Infrastructure\File;

use App\Domain\File\FileSystemInterface;
use Symfony\Component\Filesystem\Filesystem;

class AppFileSystem implements FileSystemInterface
{
    public function dump(string $path, string $content): void
    {
        $fileSystem = new Filesystem();
        $fileSystem->dumpFile($path, $content);
    }
}
