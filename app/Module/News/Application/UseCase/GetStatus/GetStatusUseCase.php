<?php

declare(strict_types=1);

namespace Module\News\Application\UseCase\GetStatus;

use Core\Domain\ValueObject\Uuid;
use Module\News\Domain\Repository\NewsRepositoryInterface;

final readonly class GetStatusUseCase
{
    public function __construct(
        private NewsRepositoryInterface $repository,
    ) {
    }

    public function __invoke(GetStatusRequest $request): GetStatusResponse
    {
        $news = $this->repository->getById(new Uuid($request->id));
        return new GetStatusResponse($news->getStatus()->value);
    }
}
