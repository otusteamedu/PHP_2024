<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\FileSystem;

use Stringable;

interface FileSystemItemInterface extends Stringable
{
    public function getSize(): int;
    public function convertToTree(string $prefix = ''): string;
}
