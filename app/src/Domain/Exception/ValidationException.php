<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use Exception;

class ValidationException extends  Exception
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