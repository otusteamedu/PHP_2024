<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\UseCase\GenerateSummaryReport\GenerateSummaryReportRequest;
use App\Application\UseCase\GenerateSummaryReport\GenerateSummaryReportUseCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GenerateSummaryReportController
{
    public function __construct(
        private readonly GenerateSummaryReportUseCase $useCase,
    ) {
    }

    #[Route('/api/v1/news/report', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['ids']) || !is_array($data['ids'])) {
            return new Response(json_encode(['error' => 'Invalid request data. "ids" field is required and must be an array.']), 400);
        }

        try {
            $generateReportRequest = new GenerateSummaryReportRequest($data['ids']);
            $response = ($this->useCase)($generateReportRequest);
            return new Response(json_encode(['report_path' => $response->reportPath]), 200, ['Content-Type' => 'application/json']);
        } catch (\Throwable $e) {
            return new Response(json_encode(['error' => $e->getMessage()]), 500);
        }
    }
}
