<?php

declare(strict_types=1);

namespace App\NewsCategory\Infrastructure\Repository;

use App\Entity\CategorySubscriber;
use App\NewsCategory\Application\Factory\SubscriberFactory;
use App\NewsCategory\Domain\Entity\Category;
use App\NewsCategory\Domain\Repository\NewsCategoryRepositoryInterface;
use App\NewsCategory\Domain\ValueObject\Name;
use App\NewsCategory\Domain\ValueObject\Subscriber;
use App\Repository\CategorySubscriberRepository;
use Doctrine\ORM\EntityManagerInterface;
use \App\Entity\Category as DoctrineCategory;

class DbNewsCategoryRepository implements NewsCategoryRepositoryInterface
{
    private EntityManagerInterface $entityManager;
    private CategorySubscriberRepository $categorySubscriberRepository;
    private SubscriberFactory $subscriberFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        CategorySubscriberRepository $categorySubscriberRepository,
        SubscriberFactory $subscriberFactory
    )
    {
        $this->entityManager = $entityManager;
        $this->categorySubscriberRepository = $categorySubscriberRepository;
        $this->subscriberFactory = $subscriberFactory;
    }

    public function addSubscriber(Category $category, Subscriber $subscriber): void
    {
        $doctrineCategory = $this
            ->entityManager
            ->getRepository(DoctrineCategory::class)
            ->find($category->getId());

        $categorySubscriber = (new CategorySubscriber())
            ->setCategory($doctrineCategory)
            ->setType($subscriber->getType()->value())
            ->setValue($subscriber->getValue()->value());

        $this->entityManager->persist($categorySubscriber);
        $this->entityManager->flush();
    }

    public function getById(int $id): ?Category
    {
        $doctrineCategory = $this
            ->entityManager
            ->getRepository(DoctrineCategory::class)
            ->find($id);

        if ($doctrineCategory === null) {
            return null;
        }

        $categorySubscribers = $this
            ->categorySubscriberRepository
            ->findAllByCategoryId($id);

        $subscribers = [];
        foreach ($categorySubscribers as $categorySubscriber){
            $subscriber = $this->subscriberFactory->getSubscriber(
                $categorySubscriber->getType(),
                $categorySubscriber->getValue()
            );

            $subscribers[] = $subscriber;
        }

        return new Category(
            $doctrineCategory->getId(),
            Name::fromString($doctrineCategory->getName()),
            $subscribers
        );
    }
}