<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Report;
use App\Domain\Entity\ReportFile;

interface ReportRepositoryInterface
{
    public function save(Report $report): ReportFile;
}
