<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Dto\LinkDto;
use App\Application\Service\LinkGeneratorInterface;
use App\Application\Service\NewsReportGeneratorInterface;
use App\Application\Service\NewsReportServiceInterface;
use App\Application\UseCase\Request\GetNewsReportRequest;
use App\Application\UseCase\Response\GetNewsReportResponse;
use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use Psr\Log\LoggerInterface;

class GetNewsReportUseCase
{
    public function __construct(
        private readonly NewsReportGeneratorInterface $reportGenerator,
        private readonly NewsReportServiceInterface $reportService,
        private readonly NewsRepositoryInterface $newsRepository,
        private readonly LinkGeneratorInterface $linkGenerator,
        private readonly LoggerInterface $logger,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(GetNewsReportRequest $request): GetNewsReportResponse
    {
        try {
            $news = $this->newsRepository->findAllByIds($request->ids);
            $reportDto = $this->reportGenerator->generate($news);
            $this->reportService->save($reportDto);
            $linkDto = $this->linkGenerator->generate(new LinkDto($reportDto->getFilename()));
            $notFoundedIds = $this->getNotFoundedIds($request->ids, $news);

            return new GetNewsReportResponse($linkDto->url, $this->generateWarnings($notFoundedIds));
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage(), ['exception' => $e]);
            throw new \Exception('Unable to generate report');
        }
    }

    private function getNotFoundedIds(array $ids, array $news): array
    {
        if (count($ids) === count($news)) {
            return [];
        }

        $newsIds = array_map(function (News $item): string {
            return (string) $item->getId();
        }, $news);

        return array_values(array_diff($ids, $newsIds));
    }

    private function generateWarnings(array $ids): array
    {
        if (0 === count($ids)) {
            return [];
        }

        return array_map(function (string $id): string {
            return sprintf('Non founded news with ID %s.', $id);
        }, $ids);
    }
}
