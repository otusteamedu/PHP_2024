<?php

declare(strict_types=1);

namespace App\Validator;

class BracketBalance implements ValidatorInterface
{
    /** @var mixed  */
    protected mixed $data;

    /**
     * @param mixed $data
     * @return void
     */
    public function setData(mixed $data): void
    {
        $this->data = $data;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        if (!is_string($this->data)) {
            return false;
        }

        $stack = [];

        for ($i = 0; $i < strlen($this->data); $i++) {
            if ($this->data[$i] === '(') {
                $stack[] = '(';
                continue;
            }
            if (empty($stack)) {
                return false;
            }
            array_pop($stack);
        }

        return empty($stack);
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return 'The balance of the brackets is off';
    }
}
