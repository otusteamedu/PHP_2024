<?php

declare(strict_types=1);

namespace App\NewsCategory\Domain\Repository;

use App\NewsCategory\Domain\Entity\Category;
use App\NewsCategory\Domain\ValueObject\Subscriber;

interface NewsCategoryRepositoryInterface
{
    public function addSubscriber(Category $category, Subscriber $subscriber): void;
    public function getById(int $id): ?Category;
}