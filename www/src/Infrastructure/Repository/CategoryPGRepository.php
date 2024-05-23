<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Category\Category;
use App\Domain\Category\CategoryRepository;
use App\Infrastructure\Entity\CategoryEntity;
use Doctrine\ORM\EntityRepository;

class CategoryPGRepository extends EntityRepository implements CategoryRepository
{

    /**
     * @return Category[]
     */
    public function findAll(): array
    {
        /** @var CategoryEntity[] $categories */
        $categories = $this->findAll();

        foreach ($categories as &$category) {
            $category = $category->getDomainModel();
        }

        return $categories;
    }

    public function findById(int $id): Category
    {
        $category = $this->find($id);

        $category = $category->getDomainModel();

        return $category;
    }

    public function save(Category $category): Category
    {
        $categoryEntity = CategoryEntity::getEntityFromDomainModel($category);

        $this->getEntityManager()->persist($categoryEntity);
        $this->getEntityManager()->flush();
        return $category;
    }

    public function delete(Category $category): void
    {
        $categoryEntity = CategoryEntity::getEntityFromDomainModel($category);

        $this->getEntityManager()->remove($categoryEntity);
        $this->getEntityManager()->flush();
    }
}