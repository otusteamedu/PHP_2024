<?php

namespace IraYu\OtusHw4;

class CommandResult implements Result
{
    protected array $errors = [];
    protected string $message = '';

    public function isSuccess(): bool
    {
        return empty($this->errors);
    }

    public function addError(string $errorMessage): void
    {
        $this->errors[] = $errorMessage;
    }

    public function addMessage(string $justMessage): void
    {
        $this->message = $justMessage;
    }
    public function getMessage(): string
    {
        return implode(PHP_EOL, array_merge($this->errors, empty($message) ? [] : [$message]));
    }
}
