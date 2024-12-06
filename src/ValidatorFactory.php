<?php

declare(strict_types=1);

namespace EmailValidation;

use EmailValidation\Factory\ValidatorFactoryInterface;
use EmailValidation\Validators\ValidatorInterface;
use EmailValidation\Validators\EmailValidator;

class ValidatorFactory implements ValidatorFactoryInterface
{
    public function emailValidator(): ValidatorInterface
    {
        return new EmailValidator();
    }
}
