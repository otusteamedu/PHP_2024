<?php

declare(strict_types=1);

namespace App\Application\UseCase\SubmitNews;

use App\Domain\Factory\NewsFactoryInterface;
use App\Domain\Repository\NewsRepositoryInterface;

class SubmitNewsUseCase
{
    private NewsFactoryInterface $newsFactory;
    private NewsRepositoryInterface $newsRepository;
    public function __construct(
        NewsFactoryInterface $newsFactory,
        NewsRepositoryInterface $newsRepository
    )
    {
        $this->newsFactory = $newsFactory;
        $this->newsRepository = $newsRepository;
    }

    public function __invoke(SubmitNewsRequest $request): SubmitNewsResponse
    {
        $news = $this->newsFactory->create($request->name, $request->author, $request->category, $request->text);
        $this->newsRepository->save($news);

        return new SubmitNewsResponse(
            $news->GetId()
        );
    }
}