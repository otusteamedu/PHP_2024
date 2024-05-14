<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Dto\NewsReportDto;

interface NewsReportServiceInterface
{
    public const REPORT_FILENAME = 'news';

    public function save(NewsReportDto $dto): string;
}
