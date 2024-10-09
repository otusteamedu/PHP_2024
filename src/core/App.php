<?php

namespace Ali;

class App
{
    private array $emails;
    public mixed $service;

    public function __construct(array $argv)
    {
        $this->emails = $this->extractEmails($argv);
        $this->service = new ValidateEmail();
    }

    protected function extractEmails(array $argv): array
    {
        return array_slice($argv, 1);
    }

    public function getEmails(): array
    {
        return $this->emails;
    }

    public function run(string $email): string
    {
        return $this->service->validate($email) ? 'valid' : 'invalid';
    }
}
