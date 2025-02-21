<?php

declare(strict_types=1);

namespace AnatolyShilyaev\Hw15\Infrastructure\Repository;

use AnatolyShilyaev\Hw15\Application\UseCase\GetReportNews\GetReportNewsRequest;
use AnatolyShilyaev\Hw15\Domain\Entity\News;
use AnatolyShilyaev\Hw15\Domain\Repository\NewsRepositoryInterface;

class DBNewsRepository implements NewsRepositoryInterface
{
    private NewsMapper $newsMapper;

    public function __construct()
    {
        $pdo = Connection::get()->connect();
        $this->newsMapper = new NewsMapper($pdo);
    }

    public function findAll(): iterable
    {
        $news = $this->newsMapper->findAll();
        return $news;
    }

    public function save(News $news): void
    {
        $newsId = $this->newsMapper->save($news);
        $reflectionProperty = new \ReflectionProperty(News::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($news, $newsId);
    }

    public function getReport(GetReportNewsRequest $request): string
    {
        $news = $this->newsMapper->getReport($request);

        $folder = "saved_reports";
        $files = glob("$folder/*.html");
        $filename = "$folder/report_" . count($files) + 1 . ".html";

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

        return "<a href='$filename' target='_blank'>Открыть файл</a>";
    }
}
