<?php

namespace AlexanderGladkov\Broker\Web\Service\MessageProcess;

use Exception;
use Throwable;

class ValidationException extends Exception
{
    private array $errors;

    public function __construct(array $errors, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
