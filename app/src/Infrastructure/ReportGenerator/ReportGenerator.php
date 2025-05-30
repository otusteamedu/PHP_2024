<?php

namespace Anatolyshilyaev\Hw14\Infrastructure\ReportGenerator;

use Ramsey\Uuid\Uuid;
use Anatolyshilyaev\Hw14\Application\ReportGenerator\ReportGeneratorInterface;
use Anatolyshilyaev\Hw14\Application\ReportGenerator\ReportGeneratorRequest;
use Anatolyshilyaev\Hw14\Application\ReportGenerator\ReportGeneratorResponse;

class ReportGenerator implements ReportGeneratorInterface
{
    /**
     * @param ReportGeneratorRequest[] $reportGeneratorRequest
     * @return ?ReportGeneratorResponse $reportGeneratorResponse
     */
    public function generate(array $reportGeneratorRequest): ?ReportGeneratorResponse
    {
        $folder = "saved_reports";
        $uuid = Uuid::uuid4();
        $filename = "$folder/report_" . $uuid . ".html";

        // Создаём папку, если её нет
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $html = "<ul>";

        foreach ($reportGeneratorRequest as $request) {
            $title = $request->title;
            $url = $request->url;
            $html .= "<li><a href='$url'>$title</a></li>";
        }
        $html .= "</ul>";

        // Сохраняем файл
        file_put_contents($filename, $html);
        return new ReportGeneratorResponse($filename);
    }
}
