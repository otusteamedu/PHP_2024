<?php

declare(strict_types=1);

namespace Module\News\Application\UseCase\GetList;

use Module\News\Domain\Entity\News;
use Module\News\Domain\Repository\NewsRepositoryInterface;

final readonly class GetListUseCase
{
    public function __construct(
        private NewsRepositoryInterface $repository,
    ) {
    }

    public function __invoke(): ListResponse
    {
        $news = $this->repository->getAll();
        return new ListResponse(
            ...array_map(static function (News $news): ListItem {
                return new ListItem(
                    $news->getId(),
                    $news->getUrl()->getValue(),
                    $news->getTitle()->getValue(),
                    $news->getDate()
                );
            }, $news)
        );
    }
}
