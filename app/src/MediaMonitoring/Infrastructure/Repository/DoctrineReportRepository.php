<?php

/**
 * @noinspection PhpMultipleClassDeclarationsInspection
 */

declare(strict_types=1);

namespace App\MediaMonitoring\Infrastructure\Repository;

use App\MediaMonitoring\Domain\Entity\Report;
use App\MediaMonitoring\Domain\Repository\ReportRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineReportRepository extends ServiceEntityRepository implements ReportRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Report::class);
    }

    public function findById(int $id): ?Report
    {
        return $this->find($id);
    }

    public function save(Report $report): Report
    {
        $entityManager = $this->getEntityManager();

        $entityManager->persist($report);
        $entityManager->flush();

        return $report;
    }
}
