<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Queue\QueueJobInterface;
use App\Application\Queue\Request\QueueRequest;
use App\Domain\Repository\NewsInterface;
use App\Domain\Entity\News;
use App\Application\UseCase\Request\CreateNewsRequest;
use App\Application\UseCase\Response\CreateNewsResponse;
use App\Domain\ValueObject\Url;
use App\Domain\ValueObject\Title;

class CreateNews
{
    public function __construct(
        private NewsInterface $newsRepository,
        private QueueJobInterface $queueJob,
    ) {} // phpcs:ignore

    public function __invoke(CreateNewsRequest $request): CreateNewsResponse
    {
        $news = new News(
            new Url($request->url),
            new Title($request->title),
        );

        $this->newsRepository->save($news);

        $this->queueJob->push(new QueueRequest($news->getId()));

        return new CreateNewsResponse($news->getId());
    }
}
