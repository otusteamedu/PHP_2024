<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\FileSystem\Short;

use Rmulyukov\Hw\FileSystem\FileSystemItemInterface;

class File implements FileSystemItemInterface
{
    public function __construct(
        protected readonly string $path,
        protected readonly string $name,
        protected readonly int $size
    ) {
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function convertToTree(string $prefix = ''): string
    {
        return sprintf("\n %s %s", $prefix, $this);
    }

    public function __toString(): string
    {
        return sprintf("%s (%d)", $this->name, $this->size);
    }
}
