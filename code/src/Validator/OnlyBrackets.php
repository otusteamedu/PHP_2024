<?php

declare(strict_types=1);

namespace App\Validator;

class OnlyBrackets implements ValidatorInterface
{
    /** @var mixed */
    protected mixed $data;

    /**
     * @param mixed $data
     * @return void
     */
    public function setData(mixed $data): void
    {
        $this->data = $data;
    }

    public function isValid(): bool
    {
        if (!is_string($this->data)) {
            return false;
        }

        for ($i = 0; $i < strlen($this->data); $i++) {
            if (!in_array($this->data[$i], ['(', ')'])) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return 'The string contains denied symbols';
    }
}
