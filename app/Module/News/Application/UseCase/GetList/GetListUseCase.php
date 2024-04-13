<?php

declare(strict_types=1);

namespace Module\News\Application\UseCase\GetList;

use Module\News\Domain\Entity\News;
use Module\News\Domain\Repository\NewsQueryRepositoryInterface;

final readonly class GetListUseCase
{
    public function __construct(
        private NewsQueryRepositoryInterface $repository,
    ) {
    }

    public function __invoke(): ListResponse
    {
        $newsCollection = $this->repository->getAll();
        return new ListResponse(
            ...array_map(static function (News $news): ListItem {
                return new ListItem(
                    $news->getId(),
                    $news->getUrl()->getValue(),
                    $news->getTitle()->getValue(),
                    $news->getDate()
                );
            }, $newsCollection->all())
        );
    }
}
