<?php

namespace PaymentServiceBundle\Controller\http\Report\Create\v2;

use PaymentServiceBundle\Domain\DTO\Bus\PaymentCreateDTO;
use PaymentServiceBundle\Domain\DTO\Bus\ReportCreateDTO;
use PaymentServiceBundle\Domain\Service\BusService;
use Symfony\Component\Uid\Uuid;

class Handler
{
    public function __construct(
        private readonly BusService $busService,
    ) {
    }

    public function create(RequestDTO $requestDTO): string
    {
        $uuid = Uuid::v1();

        $reportCreateDTO = new ReportCreateDTO(
            $uuid,
            $requestDTO->userId,
            $requestDTO->userEmail,
            $requestDTO->periodBegin,
            $requestDTO->periodEnd,
            $requestDTO->showDeleted ?? null
        );

        if ($this->busService->sendReportCreateMessage($reportCreateDTO)) {
            return $uuid;
        }

        return 'The service is temporarily unavailable. Try again later.';
    }
}
