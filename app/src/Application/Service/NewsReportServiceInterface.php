<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Dto\NewsReportDto;

interface NewsReportServiceInterface
{
    public function save(NewsReportDto $dto): void;
}
