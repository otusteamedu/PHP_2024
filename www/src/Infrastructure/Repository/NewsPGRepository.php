<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\News\News;
use App\Domain\News\NewsRepository;
use App\Domain\State\AbstractState;
use App\Infrastructure\Entity;
use Doctrine\ORM\EntityRepository;

class NewsPGRepository extends EntityRepository implements NewsRepository
{
    public function findAll(): array
    {
        /** @var Entity\NewsEntity[] $categories */
        $newsList = parent::findAll();

        foreach ($newsList as &$news) {
            $news = $news->getDomainModel();
        }

        return $newsList;
    }

    public function findNewsOfId(int $id): News
    {
        $news = $this->find($id);

        return $news->getDomainModel();
    }

    public function updateState(News $news): News
    {
        /** @var Entity\NewsEntity $newsEntity */
        $newsEntity = parent::find($news->getId());
        $newsEntity->setState($news->getState()->toScalar());

        $this->getEntityManager()->flush();
        return $news;
    }
    public function save(News $news): News
    {
        $newsEntity = Entity\NewsEntity::getEntityFromDomainModel($news, $this->getEntityManager());

        $this->getEntityManager()->persist($newsEntity);
        $this->getEntityManager()->flush();
        return $news;
    }

    public function delete(News $news): void
    {
        $newsEntity = Entity\NewsEntity::getEntityFromDomainModel($news);

        $this->getEntityManager()->remove($newsEntity);
        $this->getEntityManager()->flush();
    }
}
