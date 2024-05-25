<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Category\Category;
use App\Domain\Category\CategoryRepository;
use App\Domain\User\User;
use App\Infrastructure\Entity\CategoryEntity;
use App\Infrastructure\Entity\UserEntity;
use Doctrine\Common\Collections\ArrayCollection;
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

    public function updateSubscribers(Category $category): Category
    {
        /** @var CategoryEntity $categoryEntity */
        $categoryEntity = parent::find($category->getId());

        $users = $category->getSubscribers();
        $newUserUsernames = array_map(fn(User $user) => $user->getUsername(), $users);

        $newUserEntities = $this->getEntityManager()->getRepository(UserEntity::class)->findBy(['username' => $newUserUsernames]);
        $categoryEntity->setSubscribers(new ArrayCollection($newUserEntities));
        $this->getEntityManager()->flush();
        return $categoryEntity->getDomainModel();
    }

    public function delete(Category $category): void
    {
        $categoryEntity = CategoryEntity::getEntityFromDomainModel($category);

        $this->getEntityManager()->remove($categoryEntity);
        $this->getEntityManager()->flush();
    }
}