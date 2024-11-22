<?php

namespace App\Application\UseCase\News\GetAllNews;

use App\Domain\Contract\Application\Factory\ResponseFactoryInterface;
use App\Domain\Contract\Application\UseCase\GetAllNewsUseCaseInterface;
use App\Domain\Contract\Infrastructure\Repository\NewsRepositoryInterface;

class GetAllNewsUseCase implements GetAllNewsUseCaseInterface
{
    public function __construct(
        /** @var ResponseFactoryInterface<GetAllNewsUseCaseResponse> */
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly NewsRepositoryInterface $newsRepository,
    ) {
    }

    /**
     * @return GetAllNewsUseCaseResponse[]
     */
    public function __invoke(): iterable
    {
        $entityArray = $this->newsRepository->findAll();

        $responseArray = [];
        foreach ($entityArray as $news) {
            $responseArray[] = $this->responseFactory->makeResponse(
                GetAllNewsUseCaseResponse::class,
                $news->getId(),
                $news->getCreatedAt()->format('Y-m-d'),
                $news->getUrl()->getValue(),
                $news->getTitle()
            );
        }

        return  $responseArray;
    }
}
