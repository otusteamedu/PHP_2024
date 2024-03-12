<?php

declare(strict_types=1);

namespace AShutov\Hw6;

use Exception;

class Reader
{
    /**
     * @throws Exception
     */
    public function readFile(string $path): array
    {
        $data = [];

        if (!file_exists($path)) {
            throw new Exception("Файл не найден");
        }

        if ($lines = file($path, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES)) {
            $data = $lines;
        }

        return $data;
    }
}
