<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Application\Dto\NewsReportDto;
use App\Application\Service\NewsReportServiceInterface;
use Symfony\Component\Filesystem\Filesystem;

class NewsReportService implements NewsReportServiceInterface
{
    public function __construct(
        private readonly string $projectDir,
        private readonly string $reportFolder,
    ) {
    }

    public function save(NewsReportDto $dto): void
    {
        $filename = $dto->getFilename();
        $filenamePath = sprintf('%s/%s/%s/%s', $this->projectDir, 'public', $this->reportFolder, $filename);
        $filesystem = new FileSystem();
        $filesystem->dumpFile($filenamePath, $dto->content);
    }
}
