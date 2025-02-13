<?php

declare(strict_types=1);

namespace App;

use App\Composite\Composite;
use App\Composite\Html;
use App\Composite\Sheet;
use App\Composite\Text;
use App\Handlers\Handler;
use SplFileInfo;

class ShowDirectory
{
    private Handler $handler;
    private string $path;

    public function __construct(string $path, Handler $handler)
    {
        $this->handler = $handler;
        $this->path = $path;
        $this->show();
    }

    public function show(): string
    {
        $composite = $this->processDirectory($this->path);
        return $composite->show();
    }

    private function processDirectory(string $path, int $level = 1): Composite
    {
        $directoryIterator = new \DirectoryIterator($path);
        $composite = new Composite(new SplFileInfo($path), $level);
        $nextLevel = $level + 1;

        foreach ($directoryIterator as $fileInfo) {
            if (!$this->handler->handle($fileInfo)) {
                continue;
            }

            if ($fileInfo->isDir() && !$fileInfo->isDot()) {
                $composite->add($this->processDirectory($fileInfo->getPathname(), $nextLevel));
            } elseif ($fileInfo->isFile()) {
                $file = new SplFileInfo($fileInfo->getPathname());
                $extension = strtolower($fileInfo->getExtension());

                $composite->add(match ($extension) {
                    'txt' => new Text($file, $nextLevel),
                    'html' => new Html($file, $nextLevel),
                    default => new Sheet($file, $nextLevel),
                });
            }
        }

        return $composite;
    }
}
