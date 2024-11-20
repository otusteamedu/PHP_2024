<?php

namespace App\Domain\Services;

interface FileStorageServiceInterface
{
    public function store(string $path, string $content): string;
}
