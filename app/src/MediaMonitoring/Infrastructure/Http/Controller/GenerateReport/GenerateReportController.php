<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Infrastructure\Http\Controller\GenerateReport;

use App\MediaMonitoring\Application\UseCase\GenerateReport\GenerateReportRequest;
use App\MediaMonitoring\Application\UseCase\GenerateReport\GenerateReportUseCase;
use App\MediaMonitoring\Infrastructure\Http\Controller\GenerateReport\GenerateReportRequest as GenerateReportHttpRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/v1/reports', methods: ['POST'])]
final readonly class GenerateReportController
{
    public function __construct(
        private GenerateReportUseCase $generateReportUseCase,
        private UrlHelper $helper
    ) {}

    public function __invoke(#[MapRequestPayload] GenerateReportHttpRequest $request): JsonResponse
    {
        $path = $this->generateReportUseCase->execute(
            new GenerateReportRequest(...$request->postIds)
        )->path;

        return new JsonResponse([
            'url' => $this->helper->getAbsoluteUrl($path),
        ]);
    }
}
