<?php

namespace App\Infrastructure\Services;

use App\Domain\Services\FileStorageServiceInterface;
use Illuminate\Support\Facades\Storage;

class FileStorageService implements FileStorageServiceInterface
{
    public function store(string $path, string $content): string
    {
        Storage::disk('public')->put($path, $content);

        return Storage::disk('public')->url($path);
    }
}
