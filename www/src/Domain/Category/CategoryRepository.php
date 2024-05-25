<?php

declare(strict_types=1);

namespace App\Domain\Category;

use App\Domain\Category\Exceptions\CategoryNotFoundException;

interface CategoryRepository
{
    /**
     * @return Category[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return Category
     * @throws CategoryNotFoundException
     */
    public function findById(int $id): Category;

    public function save(Category $category): Category;

    public function delete(Category $category): void;

    public function updateSubscribers(Category $category): Category;
}