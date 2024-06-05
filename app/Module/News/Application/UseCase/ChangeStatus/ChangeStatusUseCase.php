<?php

declare(strict_types=1);

namespace Module\News\Application\UseCase\ChangeStatus;

use Core\Domain\ValueObject\Uuid;
use Module\News\Domain\Entity\Status;
use Module\News\Domain\Repository\NewsRepositoryInterface;

final readonly class ChangeStatusUseCase
{
    public function __construct(
        private NewsRepositoryInterface $repository
    ) {
    }

    public function __invoke(ChangeStatusRequest $request): void
    {
        $news = $this->repository->getById(new Uuid($request->id));
        $news->setStatus(Status::from($request->status));
        $this->repository->update($news);
    }
}
