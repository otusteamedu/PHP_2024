<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Exception\RequestValidationException;
use App\Domain\Exception\ValidationException;

class BaseUseCase
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
