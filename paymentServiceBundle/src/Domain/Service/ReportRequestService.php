<?php

namespace PaymentServiceBundle\Domain\Service;

use PaymentServiceBundle\Application\Mailer\EmailSubjectEnum;
use PaymentServiceBundle\Domain\Bus\EmailRabbitMqBusInterface;
use PaymentServiceBundle\Domain\DTO\Bus\EmailDTO;
use PaymentServiceBundle\Domain\Entity\Report;
use PaymentServiceBundle\Domain\Model\Report\InputReportModel;
use PaymentServiceBundle\Domain\Repository\ReportRepositoryInterface;

class ReportRequestService
{
    public function __construct(
        private readonly ReportRepositoryInterface $reportRepository,
        private readonly PaymentRequestService     $paymentRequestService,
        private readonly EmailRabbitMqBusInterface $sendEmailRabbitMqBus,
    ) {
    }

    public function createReportRequest(InputReportModel $model): void
    {
        $report = new Report();
        $report->setUuid($model->uuid);
        $report->setUserId($model->userId);
        $report->setUserEmail($model->userEmail);
        $report->setStatus($model->status);
        $report->setPeriodBegin($model->periodBegin);
        $report->setPeriodEnd($model->periodEnd);
        $report->setShowDeleted($model->showDeleted);

        $this->reportRepository->createReportRequest($report);

        $reportBody = $this->createReportBody($model);

        $model->body = $reportBody;

        $this->reportRepository->updateReportRequest($model);

        if ($model->userEmail) {
            $emailDTO = new EmailDTO(
                $model->uuid,
                $model->userEmail,
               EmailSubjectEnum::ReportCreated
            );
            $this->sendEmailRabbitMqBus->sendEmailMessage($emailDTO);
        }
    }

    public function createReportBody(InputReportModel $model): array
    {
        return [
            'meta' => [
                'userId' => $model->userId,
                'userEmail' => $model->userEmail ?? 'not set',
                'requestUuid' => $model->uuid,
                'showDeleted' => $model->showDeleted,
                'periodBegin' => $model->periodBegin->format('Y-m-d'),
                'periodEnd' => $model->periodEnd->format('Y-m-d'),
            ],
            'transactions' => $this->paymentRequestService->createReport($model),
        ];
    }
}
