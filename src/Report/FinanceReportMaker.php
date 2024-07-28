<?php

declare(strict_types=1);

namespace App\Report;

class FinanceReportMaker
{
    public function make(\DateTime $dateFrom, \DateTime $dateTo): string
    {
        sleep(30);
        return "Пример финансового отчета за период:" .
            " {$dateFrom->format('Y-m-d')} - {$dateTo->format('Y-m-d')}";
    }
}
