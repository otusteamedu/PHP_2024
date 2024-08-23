<?php

declare(strict_types=1);

namespace App\Application\UseCase\AddNews;

use App\Domain\Factory\NewsFactoryInterface;
use App\Domain\Repository\NewsRepositoryInterface;

readonly class AddNewsUseCase
{
    public function __construct(
        private NewsFactoryInterface $newsFactory,
        private  NewsRepositoryInterface $newsRepository
    ) {
        // 
    }

    public function __invoke(AddNewsRequest $request): AddNewsResponse
    {
        $news  = $this->newsFactory->create($request->url);

        $this->newsRepository->save($news);

        return new AddNewsResponse(
            $news->getId()
        );
    }
}
