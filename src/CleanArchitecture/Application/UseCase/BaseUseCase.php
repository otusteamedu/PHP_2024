<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\UseCase;
use AlexanderGladkov\CleanArchitecture\Application\Exception\RequestValidationException;
use AlexanderGladkov\CleanArchitecture\Domain\Exception\DomainValidationException;
use AlexanderGladkov\CleanArchitecture\Domain\Service\ValidationServiceInterface;

abstract class BaseUseCase
{
    public function __construct(private ValidationServiceInterface $validationService)
    {
    }

    /**
     * @throws RequestValidationException
     */
    protected function validateRequestModel(object $model): void
    {
        $errors = $this->validationService->validate($model);
        if (count($errors) > 0) {
            throw new RequestValidationException($errors);
        }
    }

    /**
     * @throws DomainValidationException
     */
    protected function validateDomainModel(object $model): void
    {
        $errors = $this->validationService->validate($model);
        if (count($errors) > 0) {
            throw new DomainValidationException($errors);
        }
    }
}
