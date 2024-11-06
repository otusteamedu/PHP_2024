<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Infrastructure\Storage;

use App\MediaMonitoring\Application\Storage\ReportStorageInterface;
use App\MediaMonitoring\Domain\Enum\ReportType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

final readonly class ReportStorage implements ReportStorageInterface
{
    private const BASE_PATH = '/var/export/reports';

    public function __construct(
        private KernelInterface $kernel,
        private Filesystem $filesystem,
    ) {}

    public function put(ReportType $type, string $content, ?string $name = null): string
    {
        $name ??= time();

        $filename = $name . '.' . $type->getExtension();

        $this->filesystem->dumpFile($this->getAbsolutePath($filename), $content);

        return $this->getRelativePath($filename);
    }

    public function getRelativePath(?string $path = null): string
    {
        $basePath = self::BASE_PATH;

        return $path ? $basePath . DIRECTORY_SEPARATOR . $path : $basePath;
    }

    public function getAbsolutePath(?string $path = null): string
    {
        return $this->kernel->getProjectDir() . $this->getRelativePath($path);
    }
}
