<?php

declare(strict_types=1);

namespace Otus\Hw6;

abstract class AbstractStringValidator
{
    /** @var array */
    protected array $errors = [];

    /**
     * @return bool
     */
    protected function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * @param string $message
     * @return void
     */
    protected function addError(string $message): void
    {
        $this->errors[] = $message;
    }

    /**
     * @return string
     */
    public function getErrors(): string
    {
        $result = '';
        foreach ($this->errors as $error) {
            $result .= $error . PHP_EOL;
        }

        return $result;
    }

    /**
     * @param string|null $string
     * @return bool
     */
    abstract public function validate(?string $string): bool;
}
