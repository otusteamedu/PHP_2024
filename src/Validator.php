<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Validator;

class Validator
{
    public const OPENED = '(';
    public const CLOSED = ')';

    public function validateString(mixed $inputValue): ValidatorDto
    {
        if (!is_string($inputValue) || '' === $inputValue) {
            return new ValidatorDto(ValidatorDto::NOT_VALID_VALUE, 'There is no "String" parameter in Post Request or empty');
        }

        return $this->validateParentheses($inputValue)
            ? new ValidatorDto()
            : new ValidatorDto(ValidatorDto::NOT_VALID_VALUE, ValidatorDto::NOT_VALID_MESSAGE);
    }

    private function validateParentheses(string $inputValue): bool
    {
        $parentheses = [];

        foreach (mb_str_split($inputValue) as $char) {
            if (!in_array($char, [ self::OPENED, self::CLOSED ], true)) {
                continue;
            }

            if (self::OPENED === $char) {
                $parentheses[] = $char;
            } else {
                $last = array_pop($parentheses);

                if (self::OPENED !== $last) {
                    return false;
                }
            }
        }

        return true;
    }
}
