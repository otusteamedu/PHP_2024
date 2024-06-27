<?php

namespace App\Infrastructure\CustomerTask;

use _PHPStan_01e5828ef\Nette\Neon\Exception;
use App\Domain\CustomerTask\Task;
use App\Domain\DomainException\DomainRecordNotFoundException;
use PDO;
use PDOStatement;

class CustomerTaskDataMapper
{
    private PDO $pdo;

    private PDOStatement $selectStatement;

    private PDOStatement $insertStatement;

    private PDOStatement $updateStatusStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStatement = $pdo->prepare(
            'SELECT * FROM tasks WHERE id = ?'
        );
        $this->insertStatement = $pdo->prepare(
            'INSERT INTO tasks (name, description) VALUES (?, ?)'
        );
        $this->updateStatusStatement = $pdo->prepare(
            'UPDATE tasks SET status = "handled" WHERE id = ?'
        );
    }

    public function insert(Task $customerTask): Task
    {
        $this->insertStatement->execute([
            $customerTask->getName(),
            $customerTask->getDescription()
        ]);

        $customerTask->setId((int)$this->pdo->lastInsertId());
        return $customerTask;
    }

    public function findById(string $id): Task
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);

        $result = $this->selectStatement->fetch();

        if (!$result) {
            throw new DomainRecordNotFoundException('task not find');
        }
        return new Task(
            $result['id'],
            $result['name'],
            $result['description'],
            $result['status'],
        );
    }

    public function updateStatus(string $taskId): bool
    {
        return $this->updateStatusStatement->execute([
            $taskId,
        ]);
    }
}