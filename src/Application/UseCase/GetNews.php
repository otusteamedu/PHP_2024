<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Domain\Entity\News;
use App\Domain\Repository\NewsInterface;

class GetNews
{
    public function __construct(private NewsInterface $newsRepository) {}

    /**
     * @return News[]
     */
    public function __invoke(): array
    {
        return $this->newsRepository->findBy([]);
    }
}
