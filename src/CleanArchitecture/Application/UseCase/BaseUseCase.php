<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\UseCase;

use AlexanderGladkov\CleanArchitecture\Domain\Exception\ValidationException;
use AlexanderGladkov\CleanArchitecture\Domain\Service\ValidationServiceInterface;

abstract class BaseUseCase
{
    public function __construct(private ValidationServiceInterface $validationService)
    {
    }

    /**
     * @throws ValidationException
     */
    protected function validateModel(object $model): void
    {
        $errors = $this->validationService->validate($model);
        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }
    }
}
