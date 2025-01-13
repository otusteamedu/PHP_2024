<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entity\Account;
use App\Domain\Factory\AccountFactoryInterface;
use App\Domain\Repository\AccountRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Infrastructure\Entity\Account as DbRecord;
use Doctrine\Persistence\ManagerRegistry;

class AccountOrmRepository extends ServiceEntityRepository implements AccountRepositoryInterface
{
    public function __construct(ManagerRegistry $registry, private AccountFactoryInterface $factory)
    {
        parent::__construct($registry, DbRecord::class);
    }

    public function save(Account $account): void
    {
        $dbRecord = new DbRecord();
        $dbRecord->setHolderName($account->getHolderName()->getValue());
        $dbRecord->setHolderEmail($account->getHolderEmail()->getValue());
        $em = $this->getEntityManager();
        $em->persist($dbRecord);
        $em->flush();
        $reflectionProperty = new \ReflectionProperty(Account::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($account, $dbRecord->getId());
    }

    public function findById(int $id): ?Account
    {
        $item = $this->find($id);
        if (!$item) {
            return null;
        }
        $account = $this->factory->create(
            $item->getHolderName(),
            $item->getHolderEmail()
        );
        $reflectionProperty = new \ReflectionProperty(Account::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($account, $item->getId());
        return $account;
    }
}
