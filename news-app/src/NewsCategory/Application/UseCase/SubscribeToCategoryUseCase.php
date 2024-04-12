<?php

declare(strict_types=1);

namespace App\NewsCategory\Application\UseCase;

use App\NewsCategory\Domain\Repository\NewsCategoryRepositoryInterface;
use App\NewsCategory\Domain\ValueObject\Subscriber;

class SubscribeToCategoryUseCase
{
    private NewsCategoryRepositoryInterface $newsCategoryRepository;

    public function __construct(NewsCategoryRepositoryInterface $newsCategoryRepository)
    {
        $this->newsCategoryRepository = $newsCategoryRepository;
    }

    public function __invoke(int $categoryId, Subscriber $subscriber): void
    {
        $category = $this->newsCategoryRepository->getById($categoryId);
        $category->addSubscriber($subscriber);
        $this->newsCategoryRepository->addSubscriber($category, $subscriber);
    }
}