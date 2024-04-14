<?php

declare(strict_types=1);

namespace App\Infrastructure\FileStorage;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;

class NewsReportFileStorage implements FileStorage
{
    public const PUBLIC_DIRECTORY = './public';
    public const SUBDIRECTORY = './news_reports';

    private string $directory;
    private string $baseUrl;
    private Filesystem $filesystem;

    public function __construct(
        string $projectDir,
        string $baseUrl,
        Filesystem $filesystem,
    ) {
        $this->directory = Path::join($projectDir, self::PUBLIC_DIRECTORY, self::SUBDIRECTORY);
        $this->baseUrl = $baseUrl;
        $this->filesystem = $filesystem;
    }

    public function save(string $format, string $content): string
    {
        $fileName = $this->generateFullName($format);

        $fileAbsolutePath = Path::join($this->directory, $fileName);

        $this->filesystem->dumpFile($fileAbsolutePath, $content);

        return $fileName;
    }

    public function getPublicUrl(string $filename): string
    {
        return $this->baseUrl . Path::getDirectory(self::SUBDIRECTORY) . $filename;
    }

    protected function generateFullName(string $format): string
    {
        return (new \DateTime())->format('YmdHis') . '_' . uniqid() . ".$format";
    }
}
