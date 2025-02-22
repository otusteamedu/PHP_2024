<?php

namespace App\Infrastructure\Controller;

use App\Application\Service\Feed\DTO\ReportFeedRequest;
use App\Application\Service\Feed\DTO\SubmitFeedRequest;
use App\Application\Service\Feed\ListFeedService;
use App\Application\Service\Feed\ReportFeedService;
use App\Application\Service\Feed\SubmitFeedService;
use App\Domain\Repository\PaginationParams;
use App\Infrastructure\Controller\Payload\CreateFeedRequest;
use App\Infrastructure\Controller\Payload\ListFeedRequest;
use App\Infrastructure\Controller\Payload\ReportFeedControllerRequest;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/feed', name: 'app_feed')]
final class FeedController extends AbstractController
{
    #[Route('/create', name: '_create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload] CreateFeedRequest $createFeedRequest,
        SubmitFeedService $submitFeedService,
    ): JsonResponse {
        $url = $createFeedRequest->url;

        try {
            $submitFeedResponse = $submitFeedService->execute(new SubmitFeedRequest($url));
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['id' => $submitFeedResponse->id->getValue()]);
    }

    #[Route('/list', name: '_list', methods: ['GET'])]
    public function list(
        #[MapRequestPayload] ListFeedRequest $listFeedRequest,
        ListFeedService $listFeedService,
    ): JsonResponse {
        $limit = $listFeedRequest->limit;
        $page = $listFeedRequest->page;

        $parameters = new PaginationParams($limit, $page);

        try {
            $feeds = $listFeedService->execute($parameters);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $result = [];
        foreach ($feeds as $feed) {
            $result[] = [
                'ID' => $feed->id->getValue(),
                'date' => $feed->date->format('Y-m-d H:i:s'),
                'url' => $feed->url->getValue(),
                'title' => $feed->title->getValue(),
            ];
        }

        return new JsonResponse($result);
    }

    #[Route('/report', name: '_report', methods: ['GET'])]
    public function report(
        #[MapRequestPayload] ReportFeedControllerRequest $reportFeedRequest,
        ReportFeedService $reportFeedService,
    ): JsonResponse {
        $ids = $reportFeedRequest->ids;

        try {
            $reportFeedResponse = $reportFeedService->execute(new ReportFeedRequest($ids));
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $fileName = $reportFeedResponse->fileName;
        $name = pathinfo($fileName, PATHINFO_FILENAME);

        $fileUrl = $this->generateUrl(
            'app_feed_download_report',
            ['fileName' => $name],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        return new JsonResponse(['download_url' => $fileUrl]);
    }

    #[Route('/report/download/{fileName}', name: '_download_report', methods: ['GET'])]
    public function downloadReport(
        string $fileName,
        string $reportsDir,
    ): Response {
        $filePath = $reportsDir . '/' . $fileName . '.html';

        if (!file_exists($filePath)) {
            throw $this->createNotFoundException();
        }

        return $this->file($filePath);
    }
}
