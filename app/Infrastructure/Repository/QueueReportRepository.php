<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Contract\RepositoryInterface;
use App\Domain\Entity\QueueReport;
use App\Infrastructure\Database\DatabaseConnection;
use Exception;
use ReflectionException;

final readonly class QueueReportRepository implements RepositoryInterface
{
    public function __construct(private DatabaseConnection $pdo)
    {
    }

    /**
     * @throws ReflectionException
     */
    public function getAll(): array
    {
        $result = $this->pdo->queryAll(sql: 'SELECT * FROM queue_reports');

        return array_map(
            fn($queueReport) => $this->mapQueueReports($queueReport),
            $result
        );
    }

    /**
     * @throws ReflectionException
     */
    public function getByIds(array $ids): array
    {
        $idsRaw = str_repeat('?,', count($ids) - 1) . '?';
        $result = $this->pdo->queryAll("SELECT * FROM queue_reports WHERE id IN ($idsRaw)", $ids);

        return array_map(
            fn($queueReport) => $this->mapQueueReports($queueReport),
            $result
        );
    }

    /**
     * @throws ReflectionException
     */
    public function findBy(string $column, mixed $value): array
    {
        $result = $this->pdo->queryAll("SELECT * FROM queue_reports WHERE {$column} = :value", [
            'value' => $value
        ]);

        if (!count($result)) {
            return [];
        }

        return array_map(
            fn($queueReport) => $this->mapQueueReports($queueReport),
            $result
        );
    }

    /**
     * @throws Exception
     */
    public function save($entity): int
    {
        /**
         * @var QueueReport $entity
         */
        $rowCount = $this->pdo->execute(
            'INSERT INTO queue_reports (uid, status, file_path, created_at, updated_at) 
                    VALUES (:uid, :status, :file_path, :created_at, :updated_at)',
            [
                'uid' => $entity->getUid(),
                'status' => $entity->getStatus(),
                'file_path' => $entity->getFilePath(),
                'created_at' => $entity->getCreatedAt(),
                'updated_at' => $entity->getUpdatedAt(),
            ]
        );

        if (!$rowCount) {
            throw new \Exception('Queue Report not created');
        }

        $this->setId($entity, $this->pdo->lastInsertId());

        return $entity->getId();
    }

    /**
     * @throws Exception
     */
    public function update($entity): int
    {
        /**
         * @var QueueReport $entity
         */

        if (!$entity->getId()) {
            throw new Exception('entity not id');
        }

        $modifiedList = $entity->getModifiedFields();

        if (!count($modifiedList)) {
            return 0;
        }

        $paramsList = [];
        $columns = [];

        foreach ($modifiedList as $key => $value) {
            $paramsList[":{$key}"] = $value;
            if ($key !== 'id') {
                $columns[] = "$key" . '=' . ":{$key}";
            }
        }

        $columns = implode(', ', $columns);
        $sql = "UPDATE queue_reports SET {$columns} WHERE id = {$entity->getId()}";

        $entityId = $this->pdo->execute($sql, $paramsList);

        if (!$entityId) {
            throw new \Exception('Queue Report not updated');
        }

        return $entityId;
    }

    /**
     * @throws ReflectionException
     */
    private function mapQueueReports(array $rawQueueReport): QueueReport
    {
        $queueReport = new QueueReport(
            $rawQueueReport['uid'],
            $rawQueueReport['status'],
            $rawQueueReport['file_path'],
            $rawQueueReport['created_at'],
            $rawQueueReport['updated_at']
        );
        $this->setId($queueReport, $rawQueueReport['id']);

        return $queueReport;
    }

    /**
     * @throws ReflectionException
     */
    private function setId(QueueReport $queueReport, int $id): void
    {
        (new \ReflectionClass($queueReport))
            ->getProperty('id')
            ->setValue($queueReport, $id);
    }
}
