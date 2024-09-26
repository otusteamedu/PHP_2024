<?php

namespace IraYu\Hw6;

class Result
{
    /**
     * @var \Error[]
     */
    protected array $errors = [];

    public function isSucceed(): bool
    {
        return empty($this->errors);
    }

    public function addError(\Error $error): static
    {
        $this->errors[] = $error;

        return $this;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
