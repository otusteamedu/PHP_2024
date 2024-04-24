<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Factory;

use Rmulyukov\Hw\FileSystem\FileSystemItemInterface;
use Rmulyukov\Hw\FileSystem\Short\Directory;
use Rmulyukov\Hw\FileSystem\Short\File;
use RuntimeException;

abstract class AbstractFileSystemItemFactory
{
    abstract public function createFile(string $path): File;
    abstract public function createDirectory(string $path): Directory;
    public function createTree(string $path): FileSystemItemInterface
    {
        $type = filetype($path);
        return match ($type) {
            'dir' => $this->createAndPopulateDir($path),
            'file' => $this->createFile($path),
            default => throw new RuntimeException("Unknown file type $type")
        };
    }

    private function createAndPopulateDir(string $path): Directory
    {
        $dir = $this->createDirectory($path);
        $content = scandir($path);

        //Если false или массив с двумя элементами (. и ..), то считаем папку пустой и выходим
        if (!$content || count($content) <= 2) {
            return $dir;
        }

        for ($i = 2; $i < count($content); $i++) {
            $dir->addChild(
                $this->createTree("$path/$content[$i]")
            );
        }

        return $dir;
    }
}
