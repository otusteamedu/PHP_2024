<?php

declare(strict_types=1);

namespace App\Infrastructure\FileStorage;

interface FileStorage
{
    public function save(string $format, string $content): string;

    public function getPublicUrl(string $filename): string;
}
