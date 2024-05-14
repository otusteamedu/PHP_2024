<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Application\Service\NewsReportServiceInterface;
use App\Domain\Dto\NewsReportDto;
use Symfony\Component\Filesystem\Filesystem;

class NewsReportService implements NewsReportServiceInterface
{
    public function __construct(private readonly string $projectDir, private readonly string $reportFolder)
    {
    }

    public function save(NewsReportDto $dto): string
    {
        $filename = sprintf('%s.%s', NewsReportServiceInterface::REPORT_FILENAME, $dto->extension);
        $filenamePath = sprintf('%s/%s/%s/%s', $this->projectDir, 'public', $this->reportFolder, $filename);
        $filesystem = new FileSystem();
        $filesystem->dumpFile($filenamePath, $dto->content);

        return $filename;
    }
}
