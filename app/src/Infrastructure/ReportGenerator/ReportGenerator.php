<?php

namespace Anatolyshilyaev\Hw14\Infrastructure\ReportGenerator;

use Ramsey\Uuid\Uuid;
use Anatolyshilyaev\Hw14\Application\ReportGenerator\ReportGeneratorInterface;

class ReportGenerator implements ReportGeneratorInterface
{
    public function generate(array $news): ?string
    {
        $folder = "saved_reports";
        $uuid = Uuid::uuid4();
        $filename = "$folder/report_" . $uuid . ".html";

        // Создаём папку, если её нет
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $html = "<ul>";

        foreach ($news as $new) {
            $title = $new["title"];
            $url = $new["url"];
            $html .= "<li><a href='$url'>$title</a></li>";
        }
        $html .= "</ul>";

        // Сохраняем файл
        file_put_contents($filename, $html);
        return $filename;
    }
}
