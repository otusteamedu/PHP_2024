<?php

declare(strict_types=1);

namespace SFadeev\Hw6;

use SFadeev\Hw6\Validator\Exception\BaseValidationException;
use SFadeev\Hw6\Validator\ValidatorInterface;

class ValidationService
{
    /**
     * @param ValidatorInterface[] $validators
     */
    public function __construct(
       private array $validators
    ) {
    }

    /**
     * @param mixed $value
     * @return void
     *
     * @throws BaseValidationException
     */
    public function validate(mixed $value): void
    {
        foreach ($this->validators as $validator) {
            $validator->validate($value);
        }
    }
}