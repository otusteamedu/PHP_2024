<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\UseCase;

use AlexanderGladkov\CleanArchitecture\Application\UseCase\Exception\RequestValidationException;
use AlexanderGladkov\CleanArchitecture\Domain\Exception\ValidationException;

abstract class BaseUseCase
{
    public function __construct()
    {
    }

    /**
     * @throws RequestValidationException
     */
    protected function checkRequestValidationErrors(array $errors)
    {
        if (count($errors) > 0) {
            throw RequestValidationException::create($errors);
        }
    }

    /**
     * @throws ValidationException
     */
    protected function checkValidationErrors(array $errors)
    {
        if (count($errors) > 0) {
            throw ValidationException::create($errors);
        }
    }
}
