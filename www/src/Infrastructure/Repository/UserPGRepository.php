<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;


use App\Domain\Category\Category;
use App\Domain\User\User;
use App\Domain\User\UserRepository;
use App\Infrastructure\Entity\News;
use Doctrine\ORM\EntityRepository;
use App\Infrastructure\Entity\User as EntityUser;

class UserPGRepository extends EntityRepository implements UserRepository
{
    /**
     * @return User[]
     */
    public function findAll(): array
    {
        $users = parent::findAll();

        foreach ($users as &$user) {
            $user = $this->buildDomainUser($user);
        }

        return $users;
    }

    public function findById(string $nickname): User
    {
        $user = $this->find($nickname);

        $user = $this->buildDomainUser($user);

        return $user;
    }

    public function save(User $user): User
    {
//        $user->setNews(json_encode($user->getNews()));
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
        return $user;
    }

    public function delete(User $user): void
    {
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }

    protected static function buildEntityUser(User $user): EntityUser
    {
        return new EntityUser(
            $user->getUsername(),
            $user->getNews(),
        );
    }

    protected function buildDomainUser(EntityUser $user): User
    {
        $news = [];
        $newsIds = $user->getNews();
        foreach ($newsIds as $newsId) {
            $news[] = $this
                ->getEntityManager()
                ->getRepository(News::class)
                ->find($newsId);
        }
        $user->setNews($news);
        return $user;
    }
}