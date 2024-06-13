<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\UseCase\Exception;

use Exception;

class RequestValidationException extends Exception
{
    private array $errors;

    public function setErrors(array $errors): self
    {
        $this->errors = $errors;
        return $this;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public static function create(array $errors): self
    {
        return (new self())->setErrors($errors);
    }
}
