<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Dto\NewsReportDto;

interface NewsReportGeneratorInterface
{
    public function generate(array $news): NewsReportDto;
}
