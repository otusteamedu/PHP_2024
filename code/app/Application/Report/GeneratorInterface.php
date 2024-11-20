<?php

declare(strict_types=1);

namespace App\Application\Report;

use App\Domain\Entity\News;

interface GeneratorInterface
{
    /**
     * @param ReportItemCollection $items
     * @return string
     */
    public function generate(ReportItemCollection $items): string;
}
