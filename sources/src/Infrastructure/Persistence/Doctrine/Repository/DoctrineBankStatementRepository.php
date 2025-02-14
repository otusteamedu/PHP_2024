<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\BankStatement;
use App\Domain\Repository\BankStatementRepositoryInterface;
use App\Infrastructure\Persistence\Doctrine\Entity\DoctrineBankStatement;
use App\Infrastructure\Persistence\Doctrine\Mapper\DoctrineBankStatementMapper;
use Doctrine\ORM\EntityManagerInterface;

readonly class DoctrineBankStatementRepository implements BankStatementRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface      $entityManager,
        private DoctrineBankStatementMapper $mapper
    )
    {
    }

    public function save(BankStatement $bankStatement): void
    {
        $doctrineBankStatement = $this->mapper->toDoctrine($bankStatement);

        $this->entityManager->persist($doctrineBankStatement);
        $this->entityManager->flush();

        $bankStatement->setId($doctrineBankStatement->getId());
    }

    public function findInRange(int $account, \DateTime $dateFrom, \DateTime $dateTo): ?array
    {
        return $this->entityManager
            ->getRepository(DoctrineBankStatement::class)
            ->createQueryBuilder('bs')
            ->where('bs.account = :account')
            ->andWhere('bs.date BETWEEN :dateFrom AND :dateTo')
            ->setParameter('account', $account)
            ->setParameter('dateFrom', $dateFrom)
            ->setParameter('dateTo', $dateTo)
            ->getQuery()
            ->getResult();
    }
}
