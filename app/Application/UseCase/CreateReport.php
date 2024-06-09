<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\CreateReportRequest;
use App\Application\UseCase\Response\CreateReportResponse;
use App\Domain\Contract\RepositoryInterface;
use App\Domain\Entity\News;

final class CreateReport
{
    public function __construct(private readonly RepositoryInterface $repository)
    {
    }

    public function __invoke(CreateReportRequest $request): array
    {
        $items = $this->getItems($request->ids);

        return array_map(fn(News $news) => new CreateReportResponse($news->getUrl(), $news->getTitle()), $items);
    }

    private function getItems(array $ids): array
    {
        return $this->repository->getByIds($ids);
    }
}
