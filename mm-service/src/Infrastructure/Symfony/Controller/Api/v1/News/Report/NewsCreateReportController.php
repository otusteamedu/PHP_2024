<?php
declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller\Api\v1\News\Report;

use App\Application\Report\ReportGeneratorInterface;
use App\Application\UseCase\NewsReportCreateUseCase\Boundary\NewsCreateReportRequest;
use App\Application\UseCase\NewsReportCreateUseCase\NewsCreateReportUseCase;
use App\Infrastructure\FileStorage\NewsReportFileStorage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/api/v1/news/report',
    name: 'news_list',
    methods: ['GET']
)]
class NewsCreateReportController extends AbstractController
{
    public function __construct(
        private NewsCreateReportUseCase $createReportUseCase,
        private NewsReportFileStorage $newsReportFileStorage,
    )
    {
    }

    public function __invoke(Request $request): Response
    {
        $ids = $request->get('ids', []);

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

        $format = ReportGeneratorInterface::FORMAT_HTML;

        $boundary = new NewsCreateReportRequest(
            $ids,
            $format,
            $template
        );

        $content = $this->createReportUseCase->__invoke($boundary);

        $fileName = $this->newsReportFileStorage->save($format, $content);

        return new JsonResponse([
            'url' => $this->newsReportFileStorage->getPublicUrl($fileName),
        ]);
    }
}
