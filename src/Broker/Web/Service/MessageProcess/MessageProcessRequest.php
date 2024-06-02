<?php

declare(strict_types=1);

namespace AlexanderGladkov\Broker\Web\Service\MessageProcess;

class MessageProcessRequest
{
    private string $email;
    private string $text;
    private array $errors = [];

    public function __construct(string $email, string $message)
    {
        $this->email = trim($email);
        $this->text = trim($message);
    }

    public function validate(): array
    {
        $this->errors = [];
        if (!$this->hasErrorsInField('email') && $this->email === '') {
            $this->addError('email', 'Email не должен быть пустым');
        }

        if (!$this->hasErrorsInField('email')  && filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->addError('email', 'Email не корректный');
        }

        if (!$this->hasErrorsInField('text') &&  $this->text === '') {
            $this->addError('text', 'Сообщение не должно быть пустым');
        }

        return $this->errors;
    }

    private function hasErrorsInField(string $field): bool
    {
        return isset($this->errors[$field]) && count($this->errors[$field]) !== 0;
    }

    private function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'text' => $this->text
        ];
    }
}
