<?php

declare(strict_types=1);

namespace Irayu\Hw15\Domain\Repository;

use Irayu\Hw15\Domain\Entity\Report;

interface ReportRepositoryInterface
{
    public function save(Report $report): void;

    public function findByHash(string $hash): ?Report;
}
