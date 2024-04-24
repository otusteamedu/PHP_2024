<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\FileSystem\Long;

use Rmulyukov\Hw\FileSystem\Short\File;

final class LongTextFile extends File
{
    public function __toString(): string
    {
        $preview = file_get_contents($this->path, length: 50);
        return sprintf("%s (%s)", parent::__toString(), $preview);
    }
}
