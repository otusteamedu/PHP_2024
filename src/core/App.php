<?php

namespace Ali;

class App
{
    private array $emails;
    private mixed $service;

    public function __construct(array $argv)
    {
        $this->emails = $this->extractEmails($argv);
        $this->service = new ValidateEmail();
    }

    public function getEmails(): array
    {
        return $this->emails;
    }

    public function run(string $email): string
    {
        return $this->service->validate($email) ? 'valid' : 'invalid';
    }

    private function extractEmails(array $argv): array
    {
        return array_slice($argv, 1);
    }
}
