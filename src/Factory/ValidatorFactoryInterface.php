<?php

declare(strict_types=1);

namespace EmailValidation\Factory;

use EmailValidation\Validators\ValidatorInterface;

interface ValidatorFactoryInterface
{
   public function emailValidator(): ValidatorInterface;
}
