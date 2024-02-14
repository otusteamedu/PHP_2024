<?php

declare(strict_types=1);

namespace SFadeev\HW4\Validator;

class BracketSetValidator
{
    public function validate(mixed $value): void
    {
        if (!is_string($value)) {
            throw new InvalidBracketSetException(sprintf( 'Value type should be string, %s given', gettype($value)));
        }

        if ('' === $value) {
            throw new InvalidBracketSetException('Value should not be empty.');
        }

        $countBalance = 0;
        $wrongStruct = false;
        foreach (str_split($value) as $char) {
            if ($countBalance < 0) $wrongStruct = true;
            switch ($char) {
                case '(':
                    $countBalance++;
                    break;
                case ')':
                    $countBalance--;
                    break;
                default:
                    throw new InvalidBracketSetException(sprintf('Value contains unexpected char: %s', $char));
            }
        }

        if ($countBalance > 0) {
            throw new InvalidBracketSetException(sprintf('The value contains %d redundant open brackets', abs($countBalance)));
        } else if ($countBalance < 0) {
            throw new InvalidBracketSetException(sprintf('The value contains %d redundant closed brackets', abs($countBalance)));
        } else if ($wrongStruct) {
            throw new InvalidBracketSetException('The value contains wrong bracket struct');
        }
    }
}
