<?php

declare(strict_types=1);

namespace App\Application\Actions\CustomerTask;

use App\Application\Actions\Action;
use App\Domain\CustomerTask\TaskRepositoryInterface;
use Psr\Log\LoggerInterface;

abstract class CustomerTaskAction extends Action
{
    protected TaskRepositoryInterface $customerTasksRepository;

    public function __construct(LoggerInterface $logger, TaskRepositoryInterface $customerTasksRepository)
    {
        parent::__construct($logger);
        $this->customerTasksRepository = $customerTasksRepository;
    }
}
