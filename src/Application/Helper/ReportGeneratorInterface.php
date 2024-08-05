<?php

declare(strict_types=1);

namespace App\Application\Helper;

use App\Application\Helper\DTO\ReportDTO;
use App\Domain\Entity\News;

interface ReportGeneratorInterface
{
    /**
     * @param list<News> $newsReportDTOList
     * @return ReportDTO
     */
    public function generate(array $newsReportDTOList): ReportDTO;
}
