<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Application\Storage;

use App\MediaMonitoring\Domain\Enum\ReportType;

interface ReportStorageInterface
{
    public function getRelativePath(?string $path = null): string;

    public function getAbsolutePath(?string $path = null): string;

    public function put(ReportType $type, string $content, ?string $name = null): string;
}
