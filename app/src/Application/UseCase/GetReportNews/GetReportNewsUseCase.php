<?php

namespace AnatolyShilyaev\Hw15\Application\UseCase\GetReportNews;

use AnatolyShilyaev\Hw15\Domain\Factory\NewsFactoryInterface;
use AnatolyShilyaev\Hw15\Domain\Repository\NewsRepositoryInterface;

class GetReportNewsUseCase
{
    public function __construct(
        private readonly NewsFactoryInterface $newsFactory,
        private readonly NewsRepositoryInterface $newsRepository,
    ) {
        // Empty constructor
    }

    public function __invoke(GetReportNewsRequest $request): GetReportNewsResponse
    {
        //Get report
        $link = $this->newsRepository->getReport($request);

        return new GetReportNewsResponse($link);
    }
}
