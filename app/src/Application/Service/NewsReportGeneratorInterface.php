<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Dto\NewsReportDto;

interface NewsReportGeneratorInterface
{
    public function generate(array $news): NewsReportDto;
}
