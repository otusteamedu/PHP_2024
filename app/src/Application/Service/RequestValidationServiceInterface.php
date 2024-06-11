<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\UseCase\Request\Task\ProcessTaskRequest;
use App\Application\UseCase\Request\Task\SendTaskRequest;
use App\Application\UseCase\Request\Task\GetTaskStatusRequest;

interface RequestValidationServiceInterface
{
    public function validateGetTaskStatusRequest(GetTaskStatusRequest $request): array;
    public function validateSendTaskStatusRequest(SendTaskRequest $request): array;
    public function validateProcessTaskRequest(ProcessTaskRequest $request): array;
}
