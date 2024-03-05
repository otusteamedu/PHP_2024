<?php

declare(strict_types=1);

namespace SFadeev\Hw6\Validator;

use SFadeev\Hw6\Validator\Exception\InvalidEmailDomainException;
use SFadeev\Hw6\Validator\Exception\InvalidTypeException;

class EmailDomainValidator implements ValidatorInterface
{
    public function validate(mixed $value): void
    {
        if (!is_string($value)) {
            throw new InvalidTypeException(gettype($value), ['string']);
        }

        $domain = substr($value, strpos($value, '@') + 1);

        if (gethostbyname($domain) === $domain) {
            throw new InvalidEmailDomainException($value, 'Unable to resolve host');
        }
    }
}
