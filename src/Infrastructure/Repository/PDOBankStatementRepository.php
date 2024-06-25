<?php

declare(strict_types=1);

namespace Alogachev\Homework\Infrastructure\Repository;

use Alogachev\Homework\Domain\Entity\BankStatement;
use Alogachev\Homework\Domain\Repository\BankStatementRepositoryInterface;
use Alogachev\Homework\Domain\Repository\Query\UpdateStatusToReadyQuery;
use PDO;

class PDOBankStatementRepository implements BankStatementRepositoryInterface
{
    public function __construct(
        private readonly PDO $pdo,
    ) {
    }

    /**
     * ToDo: Реализовать сохранение в БД.
     */
    public function save(BankStatement $bankStatement): int
    {
        $insertStatement = $this->pdo->prepare(
            'INSERT INTO bank_statement (
                            client_name,
                            account_number,
                            start_date,
                            end_date,
                            file_name,
                            status
                            ) VALUES (
                                      :clientName,
                            :accountNumber,
                            :startDate,
                            :endDate,
                            :fileName,
                            :status
                                      )'
        );

        $insertStatement->bindValue(':clientName', $bankStatement->getClientName());
        $insertStatement->bindValue(':accountNumber', $bankStatement->getAccountNumber());
        $insertStatement->bindValue(':startDate', $bankStatement->getStartDate()->format('Y-m-d'));
        $insertStatement->bindValue(':endDate', $bankStatement->getEndDate()->format('Y-m-d'));
        $insertStatement->bindValue(':fileName', $bankStatement->getStatementFileName());
        $insertStatement->bindValue(':status', $bankStatement->getStatus()->getValue());
        $insertStatement->execute();

        return (int)$this->pdo->lastInsertId();
    }

    public function updateStatus(UpdateStatusToReadyQuery $query): void
    {
    }
}
