<?php

namespace App\Application\UseCase\ReportNews;

use App\Application\Gateway\ReportNewsGatewayInterface;
use App\Application\Gateway\ReportNewsGatewayRequest;
use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;

class ReportNewsUseCase
{
    public function __construct(
        private readonly ReportNewsGatewayInterface $reportNewsGateway,
        private readonly NewsRepositoryInterface $repository
    )
    {
    }

    public function __invoke(ReportNewsRequest $request): ReportNewsResponse
    {
        /** @var News[] $news */
        $news = $this->repository->get($request->ids);

        $requestGateway = new ReportNewsGatewayRequest($news);
        $responseGateway = $this->reportNewsGateway->getReport($requestGateway);

        return new ReportNewsResponse($responseGateway->fileUrl);
    }
}
