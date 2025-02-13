<?php

declare(strict_types=1);

namespace App\Composite;

class Composite extends FileNode
{
    public function add(FileNode|null $component): void
    {
        $this->children->attach($component);
    }

    public function remove(FileNode|null $component): void
    {
        $this->children->detach($component);
    }

    public function isComposite(): bool
    {
        return true;
    }

    public function show(): string
    {
        return array_reduce(
            iterator_to_array($this->children),
            fn($result, $child) => $result . $child->show(),
            $this->name . " " . $this->size . PHP_EOL
        );
    }
}
