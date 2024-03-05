<?php

declare(strict_types=1);

namespace SFadeev\HW4\Validator;

class BracketSetValidator
{
    const WRONG_STRUCT_MESSAGE = 'The value contains wrong bracket struct';

    public function validate(mixed $value): void
    {
        if (!is_string($value)) {
            throw new InvalidBracketSetException(sprintf('Value type should be string, %s given', gettype($value)));
        }

        if ('' === $value) {
            throw new InvalidBracketSetException('Value should not be empty');
        }

        $len = strlen($value);

        if ($len % 2 > 0) {
            throw new InvalidBracketSetException(self::WRONG_STRUCT_MESSAGE);
        }

        $countBalance = 0;
        $chars = str_split($value);
        for ($i = 0; $i < $len; $i++) {
            if ($countBalance < 0 || $countBalance > ($len - $i)) {
                throw new InvalidBracketSetException(self::WRONG_STRUCT_MESSAGE);
            }

            switch ($chars[$i]) {
                case '(':
                    $countBalance++;
                    break;
                case ')':
                    $countBalance--;
                    break;
                default:
                    throw new InvalidBracketSetException(sprintf('Value contains unexpected char: %s', $chars[$i]));
            }
        }

        if ($countBalance > 0) {
            throw new InvalidBracketSetException(self::WRONG_STRUCT_MESSAGE);
        }
    }
}
