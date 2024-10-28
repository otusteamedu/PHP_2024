<?php

namespace App\Application\UseCase\News\GetAllNews;

use App\Domain\Interface\Factory\ResponseFactoryInterface;
use App\Domain\Interface\Repository\NewsRepositoryInterface;
use App\Domain\Interface\UseCase\GetAllNewsUseCaseInterface;

class GetAllNewsUseCase implements GetAllNewsUseCaseInterface
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
        /** @var ResponseFactoryInterface<GetAllNewsUseCaseResponse> */
        private readonly ResponseFactoryInterface $responseFactory,
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
