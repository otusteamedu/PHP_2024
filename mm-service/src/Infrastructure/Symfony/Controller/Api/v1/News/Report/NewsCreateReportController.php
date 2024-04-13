<?php
declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller\Api\v1\News\Report;

use App\Application\UseCase\NewsReportCreateUseCase\Boundary\NewsCreateReportRequest;
use App\Application\UseCase\NewsReportCreateUseCase\NewsCreateReportUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    )
    {
    }

    public function __invoke(Request $request): Response
    {
        $ids = $request->get('ids', []);

        $boundary = new NewsCreateReportRequest($ids);

        $report = $this->createReportUseCase->__invoke($boundary);

        return new Response($report, Response::HTTP_OK);
    }
}
