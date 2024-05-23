<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;


use App\Domain\User\User;
use App\Domain\User\UserRepository;
use App\Infrastructure\Entity\UserEntity;
use Doctrine\ORM\EntityRepository;

class UserPGRepository extends EntityRepository implements UserRepository
{
    /**
     * @return User[]
     */
    public function findAll(): array
    {
        /** @var UserEntity[] $users */
        $users = parent::findAll();

        foreach ($users as &$user) {
            $user = $user->getDomainModel();
        }

        return $users;
    }

    public function findById(string $nickname): User
    {
        $user = parent::find($nickname);
        return $user->getDomainModel();
    }

    public function save(User $user): User
    {
        $userEntity = UserEntity::getEntityFromDomainModel($user);

        $this->getEntityManager()->persist($userEntity);
        $this->getEntityManager()->flush();
        return $user;
    }

    public function delete(User $user): void
    {
        $userEntity = UserEntity::getEntityFromDomainModel($user);

        $this->getEntityManager()->remove($userEntity);
        $this->getEntityManager()->flush();
    }
}