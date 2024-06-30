<?php

namespace Producer\Exception;

class InvalidInputException extends ApplicationException
{
    public function __construct(string $field)
    {
        parent::__construct("Invalid input: {$field}");
    }
}