<?php

declare(strict_types=1);

namespace App\Domain\Report;

use App\Domain\Entity\Report;

interface ReportGeneratorInterface
{
    public function generateHTML(iterable $newsList): ?Report;
}
