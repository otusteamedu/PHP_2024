<?php

declare(strict_types=1);

namespace App\Composite;

use SplFileInfo;

abstract class FileNode
{
    protected \SplObjectStorage $children;
    protected string $name;
    protected string $size;

    public function __construct(
        protected SplFileInfo $file,
        protected int $level
    ) {
        $this->children = new \SplObjectStorage();
        $this->name = $this->formatName();
        $this->size = $this->formatSize();
    }

    public function add(?FileNode $component): void
    {
    }

    public function remove(?FileNode $component): void
    {
    }

    public function isComposite(): bool
    {
        return false;
    }

    abstract public function show(): string;

    private function formatName(): string
    {
        return str_pad('|', $this->level, '-') . $this->file->getFilename();
    }

    private function formatSize(): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = $this->file->getSize();
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
