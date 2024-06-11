<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Task;

interface EntityValidationServiceInterface
{
    public function validateTask(Task $task): array;
}
