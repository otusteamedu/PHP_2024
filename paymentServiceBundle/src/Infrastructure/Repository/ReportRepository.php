<?php

namespace PaymentServiceBundle\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestStatusEnum;
use PaymentServiceBundle\Domain\Entity\Report;
use PaymentServiceBundle\Domain\Model\Report\InputReportModel;
use PaymentServiceBundle\Domain\Repository\ReportRepositoryInterface;

class ReportRepository implements ReportRepositoryInterface
{
    private const TIME = 10;

    public function __construct(protected readonly EntityManagerInterface $entityManager)
    {
    }

    public function createReportRequest(Report $report): void
    {
        $this->entityManager->persist($report);
        $this->entityManager->flush();
    }

    public function updateReportRequest(InputReportModel $model): void
    {
        $this->timeProcessing();

        $report = $this->entityManager->getRepository(Report::class)->findOneBy(['uuid' => $model->uuid]);

        $report->setBody($model->body);
        $report->setStatus(RequestStatusEnum::Success);
        $this->entityManager->persist($report);
        $this->entityManager->flush();
    }

    private function timeProcessing(): void
    {
        sleep(self::TIME);
    }
}
