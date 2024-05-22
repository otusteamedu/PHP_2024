<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\News\News;
use App\Domain\News\NewsRepository;
use App\Domain\User\User;
use Doctrine\ORM\EntityRepository;
use App\Infrastructure\Entity;

class NewsPGRepository extends EntityRepository implements NewsRepository
{
    public function findNewsOfId(int $id): News
    {
        return $this->find($id);
    }

    public function save(News $news): News
    {
        $news = static::buildEntityNews($news);
        $this->getEntityManager()->persist($news);
        $this->getEntityManager()->flush();
        return $news;
    }

    public function delete(News $news): void
    {
        $news = static::buildEntityNews($news);
        $this->getEntityManager()->remove($news);
        $this->getEntityManager()->flush();
    }

    protected static function buildEntityNews(News $news): Entity\News
    {
        return new Entity\News(
            $news->getId(),
            $news->getTitle(),
            $news->getAuthor(),
            $news->getCreatedAt(),
            $news->getCategory(),
            $news->getBody(),
        );
    }
}
