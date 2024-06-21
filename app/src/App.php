<?php

declare(strict_types=1);

namespace Otus\Hw6;

class App
{
    /** @var string|null */
    protected ?string $message;

    /** @var EmailValidator */
    private EmailValidator $emailValidator;

    /** @var EmailDnsValidator */
    private EmailDnsValidator $emailDnsValidator;

    public function __construct()
    {
        $this->emailValidator = new EmailValidator();
        $this->emailDnsValidator = new EmailDnsValidator();
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $emails = $this->getEmails();

        foreach ($emails as $email) {
            $this->emailValidator->validate($email);
            $this->emailDnsValidator->validate($email);
        }

        $this->setMessage();
    }

    /**
     * @return array
     */
    private function getEmails(): array
    {
        if (!empty($_SERVER['argv'])) {
            array_shift($_SERVER['argv']);
        }

        return $_SERVER['argv'] ?? [];
    }

    /**
     * @return void
     */
    protected function setMessage(): void
    {
        $errors = $this->emailValidator->getErrors();
        $errors .= $this->emailDnsValidator->getErrors();

        $this->message = !empty($errors)
            ? $errors
            : 'All emails are valid :)' . PHP_EOL;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
