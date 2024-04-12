<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CategorySubscriber;
use App\Entity\NewsCategory;
use App\NewsCategory\Domain\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategorySubscriber>
 *
 * @method CategorySubscriber|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorySubscriber|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorySubscriber[]    findAll()
 * @method CategorySubscriber[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorySubscriberRepository extends ServiceEntityRepository
{
    private NewsCategoryRepository $newsCategoryRepository;

    public function __construct(ManagerRegistry $registry, NewsCategoryRepository $newsCategoryRepository)
    {
        parent::__construct($registry, CategorySubscriber::class);
        $this->newsCategoryRepository = $newsCategoryRepository;
    }

    /**
     * @return CategorySubscriber[] Returns an array of CategorySubscriber objects
     */
    public function findAllByCategoryId(int $categoryId): array
    {
        $category = $this->newsCategoryRepository->find($categoryId);

        return self::findBy([
            'category' => $category,
        ]);
    }
}
