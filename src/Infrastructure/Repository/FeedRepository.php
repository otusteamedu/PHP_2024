<?php

/** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Feed as DomainFeed;
use App\Domain\Repository\FeedAllParameters;
use App\Domain\Repository\FeedRepositoryInterface;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;
use App\Infrastructure\Entity\Feed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use ReflectionProperty;

/**
 * @extends ServiceEntityRepository<Feed>
 */
class FeedRepository extends ServiceEntityRepository implements FeedRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Feed::class);
    }

    /**
     * @return DomainFeed[]
     */
    public function getAll(FeedAllParameters $parameters): array
    {
        $entities = $this->createQueryBuilder('Feed')
            ->setMaxResults($parameters->limit)
            ->setFirstResult(($parameters->page - 1) * $parameters->limit)
            ->orderBy('Feed.id')
            ->getQuery()
            ->getResult();

        return array_reduce(
            $entities,
            function (array $carry, Feed $entityFeed) {
                $feed = $this->create($entityFeed);
                $carry[] = $feed;

                return $carry;
            },
            []
        );
    }

    /**
     * @return DomainFeed[]
     */
    public function findByIds(array $ids): array
    {
        $entities = $this->findBy(['id' => $ids]);

        return array_reduce(
            $entities,
            function (array $carry, Feed $entityFeed) {
                $feed = $this->create($entityFeed);
                $carry[] = $feed;

                return $carry;
            },
            []
        );
    }

    public function findById(int $id): ?DomainFeed
    {
        $entity = $this->find($id);

        return $this->create($entity);
    }

    public function save(DomainFeed $feed): void
    {
        $entity = (new Feed())
            ->setCreatedAt($feed->getDate())
            ->setTitle($feed->getTitle()->getValue())
            ->setUrl($feed->getUrl()->getValue());
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        $this->addId($feed, $entity);
    }

    public function delete(DomainFeed $feed): void
    {
        $entity = $this->find($feed->getId());
        $this->getEntityManager()->remove($entity);
    }

    private function create(Feed $entity): DomainFeed
    {
        $feed = new DomainFeed($entity->getCreatedAt(), new Title($entity->getTitle()), new Url($entity->getUrl()));
        $this->addId($feed, $entity);

        return $feed;
    }

    private function addId(DomainFeed $feed, Feed $entity): void
    {
        $reflectionProperty = new ReflectionProperty(DomainFeed::class, 'id');
        $reflectionProperty->setValue($feed, $entity->getId());
    }
}
