<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\FileSystem;

abstract class AbstractCompositeItem implements FileSystemItemInterface
{
    /** @var FileSystemItemInterface[] */
    private array $children = [];

    public function addChild(FileSystemItemInterface $child): void
    {
        $this->children[] = $child;
    }

    /**
     * @return FileSystemItemInterface[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }
}
