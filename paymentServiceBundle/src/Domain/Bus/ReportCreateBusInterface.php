<?php

namespace PaymentServiceBundle\Domain\Bus;

use PaymentServiceBundle\Domain\DTO\Bus\ReportCreateDTO;

interface ReportCreateBusInterface
{
    public function sendReportCreateMessage(ReportCreateDTO $reportCreateDTO): bool;
}
