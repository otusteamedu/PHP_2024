<?php

declare(strict_types=1);

namespace App\Application\UseCase\Api\v1;

use App\Application\UseCase\Api\v1\Request\ReportStatusRequest;
use App\Application\UseCase\Api\v1\Response\ReportStatusResponse;
use App\Domain\Contract\RepositoryInterface;
use App\Domain\Entity\QueueReport;
use App\Domain\Enum\QueueReport\QueueReportStatusEnum;
use App\Domain\Exception\TransactionNotFoundException;

final readonly class ReportStatus
{
    public function __construct(private RepositoryInterface $queueReportsRepository)
    {
    }

    /**
     * @throws TransactionNotFoundException
     */
    public function __invoke(ReportStatusRequest $request): ReportStatusResponse
    {
        /**
         * @var QueueReport $queueReport
         */
        $queueReport = $this->queueReportsRepository->findBy('uid', $request->uid)[0] ?? null;

        if (!$queueReport) {
            throw new TransactionNotFoundException();
        }

        return new ReportStatusResponse(QueueReportStatusEnum::tryFrom($queueReport->getStatus()));
    }
}