<?php

declare(strict_types=1);

namespace App\Infrastructure\CustomerTask;

use App\Domain\CustomerTask\Task;
use App\Domain\CustomerTask\TaskRepositoryInterface;
use App\Infrastructure\RabbitClient;
use PHPUnit\Exception;
use Psr\Log\LoggerInterface;

class CustomerTaskRepository implements TaskRepositoryInterface
{

    private LoggerInterface $logger;
    private CustomerTaskDataMapper $customerTaskDataMapper;
    private RabbitClient $rabbitClient;

    public function __construct(
        LoggerInterface $logger,
        CustomerTaskDataMapper $customerTaskDataMapper,
        RabbitClient $rabbitClient
    ) {
        $this->logger = $logger;
        $this->customerTaskDataMapper = $customerTaskDataMapper;
        $this->rabbitClient = $rabbitClient;
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function create(Task $task): string
    {
        try {
            $insertedTask = $this->customerTaskDataMapper->insert($task);
            $queueMsg = new QueueMessage($insertedTask);
            $this->rabbitClient->sendMessage($queueMsg->getValue());
            $this->logger->info("Task of id `{{$insertedTask->getId()}}` was created.");
        } catch (Exception $exception) {
            $this->logger->info("Can't create new task.");
            throw $exception;
        }
        return (string)$insertedTask->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function getTaskStatus(string $id): string
    {
        $task = $this->customerTaskDataMapper->findById($id);
        return $task->getStatus();
    }
}
