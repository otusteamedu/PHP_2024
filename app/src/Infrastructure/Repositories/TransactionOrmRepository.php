<?php

namespace App\Infrastructure\Repositories;


use App\Domain\Factory\TransactionFactoryInterface;
use App\Domain\Repository\TransactionRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use App\Infrastructure\Entity\Transaction as DbRecord;
use App\Domain\Entity\Transaction;
use Doctrine\Persistence\ManagerRegistry;

class TransactionOrmRepository extends ServiceEntityRepository implements TransactionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry, private readonly TransactionFactoryInterface $factory)
    {
        parent::__construct($registry, \App\Infrastructure\Entity\Transaction::class);
    }

    public function save(Transaction $transaction): void
    {
        $dbRecord = new DbRecord();
        $dbRecord->setAmount($transaction->getAmount()->getValue());
        $dbRecord->setDescription($transaction->getDescription()->getValue());
        $dbRecord->setTransactionTypeId($transaction->getTransactionType()->getValue());
        $dbRecord->setAccountId($transaction->getAccountNumber()->getValue());
        $dbRecord->setCreatedAt(new \DateTime());
        $em = $this->getEntityManager();
        $em->persist($dbRecord);
        $em->flush();
        $reflectionProperty = new \ReflectionProperty(Transaction::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($transaction, $dbRecord->getId());


    }

    public function findById(int $id): ?Transaction
    {
        $item = $this->find($id);
        /** @var $item DbRecord */
        if (!$item) {
            return null;
        }
        $transaction = $this->factory->create(
            $item->getAmount(),
            $item->getDescription(),
            $item->getTransactionTypeId(),
            $item->getAccountId()
        );
        $reflectionProperty = new \ReflectionProperty(Transaction::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($transaction, $item->getId());
        return $transaction;
    }

    public function findForStatement(int $accountId, string $dateFrom, string $dateTo): iterable
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM transactions s 
            WHERE s.account_id = :account_id
            AND (s.created_at::date between :date_from and :date_to) 
            ORDER BY s.created_at ASC
            ';

        $resultSet = $conn->executeQuery($sql, [
            'account_id' => $accountId,
            'date_from' => $dateFrom,
            'date_to' => $dateTo
        ]);

        $items = $resultSet->fetchAllAssociative();
        $transactions = [];
        foreach ($items as $item){
            $transaction = $this->factory->create(
                $item['amount'],
                $item['description'],
                $item['transaction_type_id'],
                $item['account_id']
            );
            $reflectionProperty = new \ReflectionProperty(Transaction::class, 'id');
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($transaction, $item['id']);
            $reflectionProperty = new \ReflectionProperty(Transaction::class, 'date');
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($transaction, $item['created_at']);
            $transactions[] = $transaction;
        }
        return $transactions;
    }
}