<?php

namespace App\Infrastructure\Repository;

use App\Domain\Interface\Repository\FileRepositoryInterface;

class FileRepository implements FileRepositoryInterface
{
    public function store(string $fileName, string $content): false|int
    {
        return file_put_contents($fileName, $content);
    }
}
