<?php

declare(strict_types=1);


namespace Main\Validators;


abstract class AbstractValidator implements Validator
{
    protected $value;

    protected $errorMessage = '';

    public function __construct($value)
    {
        $this->value = $value;
    }

    abstract public function validate(): bool;

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}