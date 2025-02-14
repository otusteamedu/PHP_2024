<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Entity\Task;
use App\Domain\Repository\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface
{

    private string $taskDir;

    public function __construct()
    {
        $this->taskDir = __DIR__ . '/../../../var/tasks/';
    }

    public function save(Task $task): void
    {
        file_put_contents(
            $this->taskDir . $task->getId() . '.json',
            json_encode([
                'id' => $task->getId(),
                'status' => $task->getStatus(),
                'title' => $task->getTitle(),
            ])
        );
    }

    public function findOneById(string $id): ?Task
    {
        $filePath = $this->taskDir . $id . '.json';

        if (!file_exists($filePath)) {
            return null;
        }

        $data = json_decode(file_get_contents($filePath), true);

        return (new Task($data['title']))
            ->setId($id)
            ->setStatus($data['status']);
    }
}