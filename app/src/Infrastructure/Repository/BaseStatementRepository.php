<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\BankStatement;
use App\Domain\Repository\BankStatementRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;
use App\Domain\Constant\BankStatementStatus;

class BaseStatementRepository extends ServiceEntityRepository implements BankStatementRepositoryInterface
{

    public function __construct(ManagerRegistry $registry, private Connection $db)
    {
        parent::__construct($registry, BankStatement::class);
    }

    public function findById(int $id): array
    {
        $builder = $this->getEntityManager()->getConnection()->createQueryBuilder();

        $builder
            ->select("*")
            ->from("bank_statement")
            ->where("id = :id")
            ->setParameter('id', $id)
        ;
        $result = $builder->execute()->fetchAll();

        if (isset($result[0])) {
            return $result[0];
        }
        
        return [];
    }

    public function save(BankStatement $bankStatement): void
    {
        $this->getEntityManager()->persist($bankStatement);
        $this->getEntityManager()->flush();
        #$id = $bankStatement->getId();
    }

    public function setStatusProcess(int $id): void
    {
        $this->setStatus($id, BankStatementStatus::IN_PROCESS->value);
    }

    public function setStatusDone(int $id): void
    {
        $this->setStatus($id, BankStatementStatus::DONE->value);
    }

    private function setStatus(int $id, string $status): void
    {
        $builder = $this->getEntityManager()->getConnection()->createQueryBuilder();
        $builder
            ->update('bank_statement')
            ->set('status', ':status')
            ->where('id = :id')
            ->setParameter('status', $status)
            ->setParameter('id', $id)
        ;

        $builder->execute();
    }
}
