<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Infrastructure\Http\Controller\GenerateReport;

use App\MediaMonitoring\Application\UseCase\GenerateReport\GenerateReportRequest;
use App\MediaMonitoring\Application\UseCase\GenerateReport\GenerateReportUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsController]
#[Route('/api/v1/posts/report', methods: ['POST'])]
final readonly class GenerateReportController
{
    public function __construct(
        private GenerateReportUseCase $generateReportUseCase,
        private UrlGeneratorInterface $router,
    ) {}

    public function __invoke(#[MapRequestPayload] namespace\GenerateReportRequest $request): JsonResponse
    {
        $reportId = $this->generateReportUseCase->execute(
            new GenerateReportRequest($request->postIds)
        )->reportId;

        $downloadUrl = $this->router->generate(
            'reports.download',
            ['reportId' => $reportId],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        return new JsonResponse([
            'url' => $downloadUrl,
        ]);
    }
}
