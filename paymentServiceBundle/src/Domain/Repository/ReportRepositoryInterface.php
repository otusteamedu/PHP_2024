<?php

namespace PaymentServiceBundle\Domain\Repository;

use PaymentServiceBundle\Domain\Entity\Report;
use PaymentServiceBundle\Domain\Model\Report\InputReportModel;

interface ReportRepositoryInterface
{
    public function createReportRequest(Report $report): void;

    public function updateReportRequest(InputReportModel $model): void;
}
