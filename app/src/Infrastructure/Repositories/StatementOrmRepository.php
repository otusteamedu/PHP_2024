<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entity\Statement;
use App\Domain\Factory\StatementFactoryInterface;
use App\Domain\Repository\AccountRepositoryInterface;
use App\Domain\Repository\StatementRepositoryInterface;

use App\Infrastructure\Entity\Status;
use App\Infrastructure\Entity\StatusEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Infrastructure\Entity\Statement as DbRecord;
use Doctrine\Persistence\ManagerRegistry;

class StatementOrmRepository extends ServiceEntityRepository implements StatementRepositoryInterface
{


    public function __construct( ManagerRegistry $registry,  private StatementFactoryInterface $factory)
    {
        parent::__construct($registry, DbRecord::class);
    }

    /**
     * @throws \DateMalformedStringException
     */
    public function save(Statement $statement): void
    {
        $dbRecord = new DbRecord();

        $dbRecord->setAccountId($statement->getAccount()->getValue());
        $dbRecord->setDateFrom(new \DateTime($statement->getDateFrom()->getValue()));
        $dbRecord->setDateTo(new \DateTime($statement->getDateTo()->getValue()));
        $dbRecord->setStatus(StatusEnum::tryFrom($statement->getStatus()->getValue()));
        $em = $this->getEntityManager();
        $em->persist($dbRecord);
        $em->flush();

        $reflectionProperty = new \ReflectionProperty(Statement::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($statement, $dbRecord->getId());

    }

    public function findById(int $id): ?Statement
    {
        $item = $this->find($id);
        /** @var $item DbRecord */
        if(!$item){
            return null;
        }
        $statement = $this->factory->create(
            $item->getAccountId(),
            $item->getDateFrom()->format('Y-m-d'),
            $item->getDateTo()->format('Y-m-d'),
            $item->getStatus()->value
        );
        $reflectionProperty = new \ReflectionProperty(Statement::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($statement, $item->getId());
        return $statement;
    }
}