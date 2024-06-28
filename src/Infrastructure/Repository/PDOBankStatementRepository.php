<?php

declare(strict_types=1);

namespace Alogachev\Homework\Infrastructure\Repository;

use Alogachev\Homework\Domain\Entity\BankStatement;
use Alogachev\Homework\Domain\Enum\BankStatementStatusEnum;
use Alogachev\Homework\Domain\Repository\BankStatementRepositoryInterface;
use Alogachev\Homework\Domain\Repository\Query\FindBankStatementQuery;
use Alogachev\Homework\Domain\Repository\Query\UpdateStatusToReadyQuery;
use Alogachev\Homework\Domain\ValueObject\BankStatementStatus;
use DateTime;
use Exception;
use PDO;

class PDOBankStatementRepository implements BankStatementRepositoryInterface
{
    public function __construct(
        private readonly PDO $pdo,
    ) {
    }

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

        $insertStatement->bindValue(':clientName', $bankStatement->getClientName(), PDO::PARAM_STR);
        $insertStatement->bindValue(':accountNumber', $bankStatement->getAccountNumber(), PDO::PARAM_STR);
        $insertStatement->bindValue(
            ':startDate',
            $bankStatement->getStartDate()->format('Y-m-d'),
            PDO::PARAM_STR
        );
        $insertStatement->bindValue(
            ':endDate',
            $bankStatement->getEndDate()->format('Y-m-d'),
            PDO::PARAM_STR
        );
        $insertStatement->bindValue(':fileName', $bankStatement->getStatementFileName(), PDO::PARAM_STR);
        $insertStatement->bindValue(':status', $bankStatement->getStatus()->getValue(), PDO::PARAM_STR);
        $insertStatement->execute();

        return (int)$this->pdo->lastInsertId();
    }

    public function updateStatus(UpdateStatusToReadyQuery $query): void
    {
        $updateStatement = $this->pdo->prepare(
            'UPDATE bank_statement
                        SET
                            file_name = :fileName,
                            status = :status
                        WHERE id = :id'
        );
        $updateStatement->bindValue(':fileName', $query->statementFileName, PDO::PARAM_STR);
        $updateStatement->bindValue(':status', BankStatementStatusEnum::Ready->value, PDO::PARAM_STR);
        $updateStatement->bindValue(':id', $query->statementId, PDO::PARAM_INT);
        $updateStatement->execute();
    }

    /**
     * @throws Exception
     */
    public function findById(FindBankStatementQuery $query): ?BankStatement
    {
        $selectStatement = $this->pdo->prepare(
            'SELECT 
                            bs.id AS id,
                            bs.client_name AS client_name,
                            bs.account_number AS account_number,
                            bs.start_date AS start_date,
                            bs.end_date AS end_date,
                            bs.file_name AS file_name,
                            bs.status AS status FROM bank_statement bs WHERE bs.id = :id'
        );

        $selectStatement->bindValue(':id', $query->id, PDO::PARAM_INT);
        $selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $selectStatement->execute();
        $result = $selectStatement->fetch();

        return $result
            ? (new BankStatement(
                $result['client_name'],
                $result['account_number'],
                new DateTime($result['start_date']),
                new DateTime($result['end_date']),
                $result['file_name'],
                new BankStatementStatus($result['status'])
            ))
                ->setId($result['id'])
            : null;
    }
}
