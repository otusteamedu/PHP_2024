<?php
declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Entity\News;
use App\Domain\Exception\NewsNotFoundException;
use App\Domain\Repository\NewsRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<News>
 */
class NewsRepository extends ServiceEntityRepository implements NewsRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }

    public function save(News $news): void
    {
        $this->getEntityManager()->persist($news);
        $this->getEntityManager()->flush();
    }

    /**
     * @param int[] $ids
     * @return News[]
     *
     * @throws NewsNotFoundException
     */
    public function findByIds(array $ids): array
    {
        $newsList = $this->createQueryBuilder('n')
            ->where('n.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult();

        if (count($newsList) < count($ids)) {
            $foundedIds = array_map(fn(News $news) => $news->getId(), $newsList);
            throw new NewsNotFoundException(array_diff($ids, $foundedIds));
        }

        return $newsList;
    }
}
