<?php

namespace App\Application\UseCase\News\GetNewsListByIdArray;

use App\Domain\Contract\Application\Factory\ResponseFactoryInterface;
use App\Domain\Contract\Application\UseCase\GetNewsListByIdUseCaseInterface;
use App\Domain\Contract\Infrastructure\Repository\NewsRepositoryInterface;

class GetNewsListByIdUseCase implements GetNewsListByIdUseCaseInterface
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
        /** @var ResponseFactoryInterface<GetNewsListByIdUseCaseResponse> */
        private readonly ResponseFactoryInterface $responseFactory,
    ) {
    }

    /**
     * @return GetNewsListByIdUseCaseResponse[]
     */
    public function __invoke(GetNewsListByIdUseCaseRequest $request): iterable
    {
        $entityArray = $this->newsRepository->findByIdArray($request->idArray);

        $responseArray = [];
        foreach ($entityArray as $news) {
            $responseArray[] = $this->responseFactory->makeResponse(
                GetNewsListByIdUseCaseResponse::class,
                $news->getUrl()->getValue(),
                $news->getTitle()
            );
        }

        return  $responseArray;
    }
}
