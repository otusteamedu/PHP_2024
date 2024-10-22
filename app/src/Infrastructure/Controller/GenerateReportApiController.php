<?php

namespace App\Infrastructure\Controller;

use App\Application\UseCase\Dto\SubmitNewsItemsByIdsRequestDto;
use App\Application\UseCase\GenerateReportUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class GenerateReportApiController extends AbstractController
{
    public function __construct(
        private readonly GenerateReportUseCase $reportUseCase,
    ) {
    }

    #[Route('/report', methods: ['POST'])]
    public function indexAction(
        #[MapRequestPayload] SubmitNewsItemsByIdsRequestDto $urlRequestDto,
    ): JsonResponse {
        $reportResponseDto = ($this->reportUseCase)($urlRequestDto);

        return $this->json($reportResponseDto->fileSrc);
    }
}
