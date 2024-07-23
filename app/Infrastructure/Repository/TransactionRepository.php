<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Contract\RepositoryInterface;
use App\Domain\Entity\Transaction;
use App\Infrastructure\Database\DatabaseConnection;
use Exception;
use ReflectionException;

final readonly class TransactionRepository implements RepositoryInterface
{

    public function __construct(private DatabaseConnection $pdo)
    {
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     * @var Transaction $entity
     */
    public function save($entity): int
    {
        $rowCount = $this->pdo->execute(
            'INSERT INTO transactions (sum, account_from, account_to, datetime, type, status, description) 
                    VALUES (:sum, :account_from, :account_to, :datetime, :type, :status, :description)',
            [
                'sum' => $entity->getSum(),
                'account_from' => $entity->getAccountFrom(),
                'account_to' => $entity->getAccountTo(),
                'datetime' => $entity->getDatetime(),
                'type' => $entity->getType(),
                'status' => $entity->getStatus(),
                'description' => $entity->getDescription(),
            ]
        );

        if (!$rowCount) {
            throw new \Exception('Transaction not created');
        }

        $this->setId($entity, $this->pdo->lastInsertId());

        return $entity->getId();
    }

    /**
     * @throws ReflectionException
     */
    public function findBy(string $column, mixed $value): array
    {

        $result = $this->pdo->queryAll("SELECT * FROM transactions WHERE {$column} = :value", [
            'value' => $value
        ]);

        if (!count($result)) {
            return [];
        }

        return array_map(
        /**
         * @throws ReflectionException
         */ fn($transaction) => $this->mapTransaction($transaction),
            $result
        );

    }

    public function getAll(): array
    {
        $result = $this->pdo->queryAll(sql: 'SELECT * FROM transactions');

        return array_map(
        /**
         * @throws ReflectionException
         */ fn($transaction) => $this->mapTransaction($transaction),
            $result
        );
    }

    public function getByIds(array $ids): array
    {
        $idsRaw = str_repeat('?,', count($ids) - 1) . '?';
        $result = $this->pdo->queryAll("SELECT * FROM transactions WHERE id IN ($idsRaw)", $ids);

        return array_map(
        /**
         * @throws ReflectionException
         */ fn($transaction) => $this->mapTransaction($transaction),
            $result
        );
    }

    /**
     * @throws ReflectionException
     */
    private function mapTransaction(array $rawTransaction): Transaction
    {
        $transaction = new Transaction(
            (int)$rawTransaction['sum'],
            $rawTransaction['account_from'],
            $rawTransaction['account_to'],
            $rawTransaction['datetime'],
            $rawTransaction['type'],
            $rawTransaction['status'],
            $rawTransaction['description'],
        );
        $this->setId($transaction, $rawTransaction['id']);

        return $transaction;
    }

    /**
     * @throws ReflectionException
     */
    private function setId(Transaction $transaction, int $id): void
    {
        (new \ReflectionClass($transaction))
            ->getProperty('id')
            ->setValue($transaction, $id);
    }
}
