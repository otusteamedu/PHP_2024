<?php

namespace App\Infrastructure\Repository;

use App\Domain\Contract\Infrastructure\Repository\NewsRepositoryInterface;
use App\Domain\Entity\News;
use App\Domain\ValueObject\Url;

/**
 * @extends AbstractRepository<News>
 */
class NewsRepository extends AbstractRepository implements NewsRepositoryInterface
{
    public function create(News $news): News
    {
        return $this->store($news);
    }

    /**
     * @return News[]
     */
    public function findAll(): iterable
    {
        return $this->entityManager->getRepository(News::class)->findBy([], ['id' => 'ASC']);
    }

    public function findById(int $id): ?News
    {
        $repository = $this->entityManager->getRepository(News::class);

        return $id ? $repository->find($id) : null;
    }

    public function findByUrl(Url $url): ?News
    {
        $repository = $this->entityManager->getRepository(News::class);

        return $url ? $repository->findOneBy(['url.value' => $url->getValue()]) : null;
    }

    /**
     * @param array $idArray
     * @return ?News[]
     */
    public function findByIdArray(array $idArray): ?iterable
    {
        return $this->entityManager->createQuery(
            'SELECT news
            FROM App\Domain\Entity\News news
            WHERE news.id IN (:idArray)')
            ->setParameter('idArray', $idArray)
            ->getResult();
    }
}
