<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Dto\NewsDto;
use App\Application\UseCase\Request\GetNewsListRequest;
use App\Application\UseCase\Response\GetNewsListResponse;
use App\Domain\Repository\NewsRepositoryInterface;
use Psr\Log\LoggerInterface;

class GetNewsListUseCase
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
        private readonly LoggerInterface $logger,
    ) {
    }

    /**
     * @return GetNewsListResponse
     * @throws \Exception
     */
    public function __invoke(GetNewsListRequest $request): GetNewsListResponse
    {
        try {
            $news = $this->newsRepository->findAllNews($request->offset, $request->limit);
            $total = $this->newsRepository->getNewsCount();
            $dtos = array_map([ NewsDto::class, 'createFromNews' ], $news);

            return new GetNewsListResponse($dtos, $request->offset, $request->limit, $total);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage(), ['exception' => $e]);
            throw new \Exception('Unable to get news list');
        }
    }
}
