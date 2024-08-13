<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Validation;

use App\Application\UseCase\Request\Task\ProcessTaskRequest;
use App\Application\UseCase\Request\Task\SendTaskRequest;
use App\Application\UseCase\Request\Task\GetTaskStatusRequest;
use App\Application\Service\RequestValidationServiceInterface;
use App\Domain\Entity\Task;
use App\Domain\Service\EntityValidationServiceInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationService implements RequestValidationServiceInterface, EntityValidationServiceInterface
{
    private ViolationHelper $violationHelper;

    public function __construct(private ValidatorInterface $validator)
    {
        $this->violationHelper = new ViolationHelper();
    }

    public function validateTask(Task $task): array
    {
        return $this->validateObject($task);
    }

    public function validateGetTaskStatusRequest(GetTaskStatusRequest $request): array
    {
        return $this->validateObject($request);
    }

    public function validateSendTaskStatusRequest(SendTaskRequest $request): array
    {
        return $this->validateObject($request);
    }

    public function validateProcessTaskRequest(ProcessTaskRequest $request): array
    {
        return $this->validateObject($request);
    }

    private function validateObject(mixed $object): array
    {
        $errors = $this->validator->validate($object);
        if (count($errors) > 0) {
            return $this->violationHelper->convertListToArray($errors);
        } else {
            return [];
        }
    }
}
