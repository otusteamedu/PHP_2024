<?php

namespace App\Application\Composite;

use SplFileInfo;

abstract class Component
{
    protected \SplObjectStorage $children;
    protected string $name;
    protected string $size;

    public function __construct(
        protected SplFileInfo $fileInfo,
        protected int $level
    ) {
        $this->children = new \SplObjectStorage();
        $this->name = $this->getName($fileInfo);
        $this->size = $this->getSize($fileInfo);
    }
    public function add(?Component $component): void { }

    public function remove(?Component $component): void { }


    public function isComposite(): bool
    {
        return false;
    }

    abstract public function show(): string;

    private function getName(SplFileInfo $fileInfo): string
    {
        return str_pad('|', $this->level, '-') . $this->fileInfo->getFilename();
    }

    private function getSize(SplFileInfo $fileInfo): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;
        $bytes = $fileInfo->getSize();
        while (($bytes / 1024) > 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }


}