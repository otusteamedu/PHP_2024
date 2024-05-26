<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Contract\RepositoryInterface;
use App\Application\UseCase\Request\CreateReportRequest;
use App\Application\UseCase\Response\CreateReportResponse;

final class CreateReport
{
    public function __construct(private readonly RepositoryInterface $repository)
    {
    }

    public function __invoke(CreateReportRequest $request): CreateReportResponse
    {
        $items = $this->getItems($request->ids);
        $content = (new GenerateReportTemplate())($items);

        return new CreateReportResponse($content);
    }

    private function getItems(array $ids): array
    {
        return $this->repository->getByIds($ids);
    }
}
