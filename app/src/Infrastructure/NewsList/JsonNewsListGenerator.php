<?php

namespace App\Infrastructure\NewsList;

use App\Application\NewsList\NewsListGeneratorInterface;
use App\Domain\Entity\NewsItem;
use App\Domain\Repository\NewsItemRepositoryInterface;

class JsonNewsListGenerator implements NewsListGeneratorInterface
{
    public function __construct(private readonly NewsItemRepositoryInterface $repository)
    {
    }

    public function generate(): array
    {
        $result = [];

        /**
         * @var NewsItem $item
         */
        foreach ($this->repository->findAll() as $item) {
            $result[] = [
                'id' => $item->getId(),
                'title' => $item->getTitle()->getValue(),
                'url' => $item->getUrl()->getValue(),
                'date' => $item->getDate()->getValue(),
            ];
        }

        return $result;
    }
}
