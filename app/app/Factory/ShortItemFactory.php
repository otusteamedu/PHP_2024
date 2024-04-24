<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Factory;

use Rmulyukov\Hw\FileSystem\Short\Directory;
use Rmulyukov\Hw\FileSystem\Short\File;

final class ShortItemFactory extends AbstractFileSystemItemFactory
{
    public function createFile(string $path): File
    {
        return new File($path, basename($path), filesize($path));
    }

    public function createDirectory(string $path): Directory
    {
        return new Directory($path, basename($path));
    }
}
