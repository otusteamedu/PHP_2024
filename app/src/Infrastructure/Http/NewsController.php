<?php

declare(strict_types=1);

namespace PavelMiasnov\MediaMonitoring\Infrastructure\Http;

use PavelMiasnov\MediaMonitoring\Application\UseCase\CreateNews\CreateNewsRequest;
use PavelMiasnov\MediaMonitoring\Application\UseCase\CreateNews\CreateNewsResponse;
use PavelMiasnov\MediaMonitoring\Application\UseCase\CreateNews\CreateNewsUseCase;
use PavelMiasnov\MediaMonitoring\Application\UseCase\GenerateReport\GenerateReportRequest;
use PavelMiasnov\MediaMonitoring\Application\UseCase\GenerateReport\GenerateReportUseCase;
use PavelMiasnov\MediaMonitoring\Domain\Entity\News;
use PavelMiasnov\MediaMonitoring\Domain\Repository\NewsRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NewsController
{
    private CreateNewsUseCase $createNewsUseCase;
    private GenerateReportUseCase $generateReportUseCase;
    private NewsRepositoryInterface $newsRepository;

    public function __construct(
        CreateNewsUseCase $createNewsUseCase,
        GenerateReportUseCase $generateReportUseCase,
        NewsRepositoryInterface $newsRepository
    ) {
        $this->createNewsUseCase = $createNewsUseCase;
        $this->generateReportUseCase = $generateReportUseCase;
        $this->newsRepository = $newsRepository;
    }

    public function createNewsAction(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $url = $data['url'] ?? '';

        if (empty($url)) {
            return new JsonResponse(['error' => 'URL is required'], 400);
        }

        $createNewsRequest = new CreateNewsRequest($url);
        $response = ($this->createNewsUseCase)($createNewsRequest);

        return new JsonResponse(['id' => $response->getNewsId()], 201);
    }

    public function getNewsListAction(): JsonResponse
    {
        $newsList = $this->newsRepository->findAll();
        $newsData = array_map(function (News $news) {
            return [
                'id' => $news->getId(),
                'date' => $news->getDate()->format('Y-m-d H:i:s'),
                'url' => $news->getUrl()->getValue(),
                'title' => $news->getTitle()->getValue(),
            ];
        }, $newsList);

        return new JsonResponse($newsData);
    }

    public function generateReportAction(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $ids = $data['ids'] ?? [];

        if (empty($ids)) {
            return new JsonResponse(['error' => 'IDs are required'], 400);
        }

        $generateReportRequest = new GenerateReportRequest($ids);
        $response = $this->generateReportUseCase->execute($generateReportRequest);

        return new JsonResponse(['report_url' => $response->getReportUrl()]);
    }
}
