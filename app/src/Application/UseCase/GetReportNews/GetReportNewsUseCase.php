<?php

namespace Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews;

use Anatolyshilyaev\Hw14\Domain\Factory\NewsFactoryInterface;
use Anatolyshilyaev\Hw14\Domain\Repository\NewsRepositoryInterface;

class GetReportNewsUseCase
{

    public function __construct(
        private readonly NewsFactoryInterface $newsFactory,
        private readonly NewsRepositoryInterface $newsRepository,
    ) {}

    public function __invoke(GetReportNewsRequest $request): GetReportNewsResponse
    {
        //Get report
        $link = $this->newsRepository->getReport($request);

        return new GetReportNewsResponse($link);
    }
}
