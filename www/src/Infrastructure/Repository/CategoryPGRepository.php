<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Category\Category;
use App\Domain\Category\CategoryRepository;
use App\Infrastructure\Entity;
use Doctrine\ORM\EntityRepository;

class CategoryPGRepository extends EntityRepository implements CategoryRepository
{

    /**
     * @return Category[]
     */
    public function findAll(): array
    {
        $categories = $this->findAll();

        foreach ($categories as &$category) {
            $category = $this->buildDomainCategory($category);
        }

        return $categories;
    }

    public function findById(int $id): Category
    {
        $category = $this->find($id);

        $category = $this->buildDomainCategory($category);

        return $category;
    }

    public function save(Category $category): Category
    {
        $category = static::buildEntityCategory($category);

        $this->getEntityManager()->persist($category);
        $this->getEntityManager()->flush();
        return $category;
    }

    public function delete(Category $category): void
    {
        $category = static::buildEntityCategory($category);

        $this->getEntityManager()->remove($category);
        $this->getEntityManager()->flush();
    }

    protected static function buildEntityCategory(Category $category): Entity\Category
    {
        return new Entity\Category(
            $category->getTitle(),
            $category->getId(),
            $category->getSubscribers()
        );
    }

    protected function buildDomainCategory(Entity\Category $category): Category
    {
        $usersIds = $category->getSubscribers();
        $users = [];
        foreach ($usersIds as $userId) {
            $users[] = $this
                ->getEntityManager()
                ->getRepository(Entity\User::class)
                ->find($userId);
        }
        $category->setSubscribers($users);

        return $category;
    }
}