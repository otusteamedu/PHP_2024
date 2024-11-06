<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Domain\Repository;

use App\MediaMonitoring\Domain\Entity\Report;
use App\Shared\Domain\Exception\CouldNotSaveEntityException;

interface ReportRepositoryInterface
{
    public function findById(int $id): ?Report;

    /**
     * @throws CouldNotSaveEntityException
     */
    public function save(Report $report): Report;
}
