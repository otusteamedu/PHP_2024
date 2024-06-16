<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\PeriodReportDto;
use App\Rabbitmq\Message\BankReportMessage;
use App\Service\BankReportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class BankReportController extends AbstractController
{
    public function __construct(private readonly BankReportService $bankReportService)
    {
    }

    #[Route('api/v1/report', name: 'bank_report_request', methods: ['POST'])]
    public function createPeriodReport(#[MapRequestPayload] PeriodReportDto $dto): JsonResponse
    {
        try {
            $this->bankReportService->publish(BankReportMessage::creteFromPeriodReportDto($dto));

            return new JsonResponse([
                'message' => 'Bank report request has been accepted',
                'request' => $dto,
            ]);
        } catch (\Throwable $e) {
            return new JsonResponse([
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
