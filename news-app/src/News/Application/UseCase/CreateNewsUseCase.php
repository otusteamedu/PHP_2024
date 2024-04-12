<?php

declare(strict_types=1);

namespace App\News\Application\UseCase;

use App\Common\Domain\ValueObject\DateTime;
use App\News\Application\Observer\PublisherInterface;
use App\News\Application\Request\CreateNewsRequest;
use App\News\Domain\Builder\NewsBuilder;
use App\News\Domain\Repository\NewsRepositoryInterface;
use App\News\Domain\ValueObject\Content;
use App\News\Domain\ValueObject\Title;
use App\NewsCategory\Domain\Repository\NewsCategoryRepositoryInterface;
use Exception;

class CreateNewsUseCase
{
    protected NewsRepositoryInterface $newsRepository;
    protected NewsCategoryRepositoryInterface $newsCategoryRepository;
    protected PublisherInterface $publisher;

    public function __construct(
        NewsRepositoryInterface $newsRepository,
        NewsCategoryRepositoryInterface $newsCategoryRepository,
        PublisherInterface $publisher
    )
    {
        $this->newsRepository = $newsRepository;
        $this->newsCategoryRepository = $newsCategoryRepository;
        $this->publisher = $publisher;
    }

    /**
     * @throws Exception
     */
    public function __invoke(CreateNewsRequest $createNewsRequest): void
    {
        $category = $this->newsCategoryRepository->getById($createNewsRequest->categoryId);

        if ($category === null) {
            throw new Exception('Category not found');
        }

        $newsBuilder = (new NewsBuilder())
            ->setTitle(Title::fromString($createNewsRequest->title))
            ->setContent(Content::fromString($createNewsRequest->content))
            ->setCreatedAt(DateTime::now())
            ->setCategory($category);

        $news = $newsBuilder->build();
        $this->newsRepository->create($news);
        $this->publisher->notify($news);
    }
}
