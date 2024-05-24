<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;


use App\Application\UseCase\MakeReportUseCase;
use App\Application\UseCase\Request\MakeConsolidatedReportRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MakeReportController extends AbstractController
{
    public function __construct(private MakeReportUseCase $useCase)
    {
    }

    #[Route('/api/v1/reports', name: 'api_make_report', methods: ['POST'])]
    public function __invoke(MakeConsolidatedReportRequest $request): Response
    {
        try {
            $response = ($this->useCase)($request);
        } catch (\Throwable $e) {
            return $this->json(['Error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        return $this->json(['url' => $this->generateUrl($response->fileUriPath)]);
    }
}