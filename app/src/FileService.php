<?php

namespace Den\Hw6;

use Generator;

class FileService
{
    public function getLines(string $file): Generator
    {
        $f = fopen($file, 'r');
        while ($line = trim(fgets($f))) {
            if (empty($line)) {
                continue;
            }
            yield $line;
        }
        fclose($f);
    }
}
