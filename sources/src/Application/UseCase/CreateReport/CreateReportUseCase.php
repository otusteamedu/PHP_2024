<?php

declare(strict_types=1);

namespace App\Application\UseCase\CreateReport;

use App\Application\Gateway\ReportGenerator\ReportGenerator;
use App\Application\Gateway\ReportGenerator\ReportGeneratorRequest;
use App\Domain\Repository\NewsRepository;
use App\Domain\ValueObject\Ids;

readonly class CreateReportUseCase
{
    public function __construct(
        private NewsRepository  $repository,
        private ReportGenerator $reportGenerator,
    )
    {
    }

    public function __invoke(CreateReportRequest $request): CreateReportResponse
    {
        // проверка, что все id числа, возможно ее стоит в другое место вынести
        $ids = new Ids($request->getIds());

        $news = $this->repository->getNewsByIds($ids->getIds());

        $link = $this->reportGenerator->generate(new ReportGeneratorRequest($news));

        return new CreateReportResponse($link->getLink());
    }
}