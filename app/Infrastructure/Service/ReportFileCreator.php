<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Application\Exception\ReportNotCreatedException;

class ReportFileCreator
{
    /**
     * @throws ReportNotCreatedException
     */
    public function createReportFile($fileName, array $transactions): void
    {
        $content = $this->generateContent($transactions);

        if (false === file_put_contents(config('report_path') . $fileName, $content)) {
            throw new ReportNotCreatedException('File not created');
        }
    }

    private function generateContent(array $transactions): string
    {
        $content = '<meta charset="UTF-8"><ul>';

        foreach ($transactions as $item) {
            $content .= "<li><span>счёт: {$item->getAccountFrom()} | сумма: {$item->getSum()} | дата: {$item->getDateTime()}</span></li>";
        }

        $content .= '</ul> <br>';

        return $content;
    }
}
