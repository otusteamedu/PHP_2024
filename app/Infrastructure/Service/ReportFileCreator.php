<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Application\Exception\ReportNotCreatedException;

class ReportFileCreator
{
    /**
     * @throws ReportNotCreatedException
     */
    public function createReportFile($fileName, $content): void
    {
        if (false !== file_put_contents(config('report_path') . $fileName, $content)) {
            throw new ReportNotCreatedException('File not created');
        }
    }
}
