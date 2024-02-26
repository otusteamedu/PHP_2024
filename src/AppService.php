<?php

declare(strict_types=1);

namespace hw6;

class AppService
{
    public function __construct(
        private ValidatorInterface $validator
    ) {
    }

    public function validate(string $string): string
    {
        return $this->validator->validate($string)
            ? 'Валидно'
            : 'Невалидно';
    }
}
