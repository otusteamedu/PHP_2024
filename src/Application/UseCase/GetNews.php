<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Response\GetNewsResponse;
use App\Domain\Repository\NewsInterface;

class GetNews
{
    public function __construct(private NewsInterface $newsRepository) {}

    public function __invoke(): GetNewsResponse
    {
        $news = $this->newsRepository->findAll();

        return new GetNewsResponse($news);
    }
}