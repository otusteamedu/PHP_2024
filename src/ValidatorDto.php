<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Validator;

class ValidatorDto
{
    public const SUCCESS_VALUE = true;
    public const NOT_VALID_VALUE = false;
    public const SUCCESS_MESSAGE = 'The string is valid';
    public const NOT_VALID_MESSAGE = 'The string is not valid';

    public function __construct(public bool $success = self::SUCCESS_VALUE, public string $message = self::SUCCESS_MESSAGE)
    {
    }
}
