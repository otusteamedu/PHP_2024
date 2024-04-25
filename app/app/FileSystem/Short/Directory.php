<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\FileSystem\Short;

use Rmulyukov\Hw\FileSystem\AbstractCompositeItem;

class Directory extends AbstractCompositeItem
{
    public function __construct(
        protected readonly string $path,
        protected readonly string $name,
    ) {
    }

    public function getSize(): int
    {
        $size = 0;
        foreach ($this->getChildren() as $child) {
            $size += $child->getSize();
        }

        return $size;
    }

    public function convertToTree(string $prefix = ''): string
    {
        $tree = sprintf("\n %s %s", $prefix, $this);
        $prefix = empty($prefix) ? '-' : $prefix . mb_substr($prefix, 0, 1);

        foreach ($this->getChildren() as $child) {
            $tree .= $child->convertToTree($prefix);
        }

        return $tree;
    }

    public function __toString(): string
    {
        return sprintf("%s (%d)", $this->name, $this->getSize());
    }
}
