<?php

declare(strict_types=1);

namespace SFadeev\Hw6\Validator;

use SFadeev\Hw6\Validator\Exception\InvalidEmailException;
use SFadeev\Hw6\Validator\Exception\InvalidTypeException;
use RuntimeException;

class EmailPatternValidator implements ValidatorInterface
{
    const PATTERN = '/^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/';

    /**
     * @param mixed $value
     * @return void
     *
     * @throws InvalidEmailException
     * @throws InvalidTypeException
     */
    public function validate(mixed $value): void
    {
        if (!is_string($value)) {
            throw new InvalidTypeException(gettype($value), ['string']);
        }

        $match = preg_match(self::PATTERN, $value);

        if (false === $match) {
            throw new RuntimeException('preg_match function error occurred');
        }

        if (1 !== $match) {
            throw new InvalidEmailException($value);
        }
    }
}
