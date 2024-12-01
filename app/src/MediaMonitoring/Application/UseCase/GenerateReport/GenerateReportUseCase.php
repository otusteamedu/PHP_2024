<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Application\UseCase\GenerateReport;

use App\MediaMonitoring\Application\ReportGenerator\ReportGeneratorInterface;
use App\MediaMonitoring\Application\ReportGenerator\ReportItem;
use App\MediaMonitoring\Application\Storage\ReportStorageInterface;
use App\MediaMonitoring\Domain\Entity\Post;
use App\MediaMonitoring\Domain\Repository\PostRepositoryInterface;

final readonly class GenerateReportUseCase
{
    public function __construct(
        private PostRepositoryInterface $postRepository,
        private ReportGeneratorInterface $reportGenerator,
        private ReportStorageInterface $reportStorage,
    ) {}

    public function execute(GenerateReportRequest $request): GenerateReportResponse
    {
        $postIds = $request->postIds;

        $posts = empty($postIds)
            ? $this->postRepository->findAll()
            : $this->postRepository->findByIds($postIds);

        $reportItems = array_map(
            static fn(Post $post): ReportItem => new ReportItem(
                $post->getTitle()->value(),
                $post->getUrl()->value(),
            ),
            $posts
        );

        $content = $this->reportGenerator->generate(...$reportItems);

        $path = $this->reportStorage->put(
            $this->reportGenerator->getType(),
            $content
        );

        return new GenerateReportResponse($path);
    }
}
