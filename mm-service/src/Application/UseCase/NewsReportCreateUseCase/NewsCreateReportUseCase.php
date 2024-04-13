<?php
declare(strict_types=1);

namespace App\Application\UseCase\NewsReportCreateUseCase;

use App\Application\Report\ReportGeneratorInterface;
use App\Application\UseCase\NewsReportCreateUseCase\Boundary\NewsCreateReportRequest;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Infrastructure\Report\News\TwigNewsReportFormatter;

final class NewsCreateReportUseCase
{
    public function __construct(
        private NewsRepositoryInterface  $newsRepository,
        private ReportGeneratorInterface $reportGenerator,
        private TwigNewsReportFormatter  $reportFormatter, // TODO: Подумать как избавиться от зависимости
    )
    {
    }

    public function __invoke(NewsCreateReportRequest $request): string
    {
        $news = $this->newsRepository->findByIds($request->getIds());

        $template = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>News Report</title>
</head>
<body>
<h1>News Report</h1>
<ul id="news_list">
    {% for news in newsList %}
        <li><a href="{{ news.url }}">{{ news.title }}</a></li>
    {% endfor %}
</ul>
</body>
</html>
HTML;

        return $this->reportGenerator->generate(
            $news,
            $this->reportFormatter,
            ['template' => $template]
        );
    }
}
