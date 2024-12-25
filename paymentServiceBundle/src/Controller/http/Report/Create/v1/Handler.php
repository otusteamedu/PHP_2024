<?php

namespace PaymentServiceBundle\Controller\http\Report\Create\v1;

use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestStatusEnum;
use PaymentServiceBundle\Domain\Factory\ModelFactory;
use PaymentServiceBundle\Domain\Model\Report\InputReportModel;
use PaymentServiceBundle\Domain\Service\ReportRequestService;
use Symfony\Component\Uid\Uuid;
use DateTime;

class Handler
{
    public function __construct(
        /** @var ModelFactory<InputReportModel> */
        private readonly ModelFactory         $modelFactory,
        private readonly ReportRequestService $reportService,
    ) {
    }

    public function create(RequestDTO $requestDTO): string
    {
        $uuid = Uuid::v1();

        $model = $this->modelFactory->makeModel(
            InputReportModel::class,
            $uuid,
            $requestDTO->userId,
            $requestDTO->userEmail,
            RequestStatusEnum::Received,
            DateTime::createFromFormat('Y-m-d' , $requestDTO->periodBegin)->setTime(0,00),
            DateTime::createFromFormat('Y-m-d' , $requestDTO->periodEnd)->setTime(23,23, 59),
            null,
            $requestDTO->showDeleted ?? null,
        );

        $this->reportService->createReportRequest($model);

        return $uuid;
    }
}
