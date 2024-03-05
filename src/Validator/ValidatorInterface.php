<?php

declare(strict_types=1);

namespace SFadeev\Hw6\Validator;

use SFadeev\Hw6\Validator\Exception\BaseValidationException;

interface ValidatorInterface
{
    /**
     * @param mixed $value
     * @return void
     *
     * @throws BaseValidationException
     */
    function validate(mixed $value): void;
}