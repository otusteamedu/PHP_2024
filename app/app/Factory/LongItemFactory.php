<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Factory;

use Rmulyukov\Hw\FileSystem\Long\LongHtmlFile;
use Rmulyukov\Hw\FileSystem\Long\LongTextFile;
use Rmulyukov\Hw\FileSystem\Short\Directory;
use Rmulyukov\Hw\FileSystem\Short\File;

final class LongItemFactory extends AbstractFileSystemItemFactory
{
    public function createFile(string $path): File
    {
        $pathInfo = pathinfo($path);
        return match ($pathInfo['extension']) {
            'txt' => new LongTextFile($path, $pathInfo['filename'], filesize($path)),
            'html' => new LongHtmlFile($path, $pathInfo['filename'], filesize($path)),
            default => new File($path, $pathInfo['filename'], filesize($path))
        };
    }

    public function createDirectory(string $path): Directory
    {
        return new Directory($path, basename($path));
    }
}
