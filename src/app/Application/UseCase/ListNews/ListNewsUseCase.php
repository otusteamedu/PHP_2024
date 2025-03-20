<?php

namespace App\Application\UseCase\ListNews;

use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;

class ListNewsUseCase
{
    public function __construct(
        private readonly NewsRepositoryInterface $repository
    )
    {
    }

    /**
     * @return ListNewsResponse[] array
     */
    public function __invoke(): array
    {
        $newsList = $this->repository->all();

        $response = [];

        /** @var News $news */
        foreach ($newsList as $news) {
            $response[] = new ListNewsResponse(
                $news->getName()->getName(),
                $news->getUrl()->getUrl(),
                $news->getCreatedAtByFormat(),
            );
        }

        return $response;
    }
}
