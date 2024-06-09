<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Application\Exception\ReportNotCreatedException;

class ReportFileCreator
{
    /**
     * @throws ReportNotCreatedException
     */
    public function createReportFile($fileName, array $news): void
    {
        $content = $this->generateContent($news);

        if (false === file_put_contents(config('report_path') . $fileName, $content)) {
            throw new ReportNotCreatedException('File not created');
        }
    }

    private function generateContent(array $news): string
    {
        $content = '<meta charset="UTF-8"><ul>';

        foreach ($news as $item) {
            $content .= "<a href='{$item->url}'>{$item->title}</a><br>";
        }

        $content .= '</ul>';

        return $content;
    }
}
