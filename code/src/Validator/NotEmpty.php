<?php

declare(strict_types=1);

namespace App\Validator;

class NotEmpty implements ValidatorInterface
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
        return !empty($this->data);
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return 'String cannot be empty';
    }
}
