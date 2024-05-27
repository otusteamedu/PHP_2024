<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Domain\Exception;

use Exception;
use Throwable;

class ValidationException extends Exception
{
    private array $errors;

    public function __construct(array $errors, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
