<?php

declare(strict_types=1);

namespace AnatolyShilyaev\App;

class App
{
    private array $emails;

    public function __construct(string $inputString)
    {
        $this->emails = $this->extractEmails($inputString);
    }

    private function extractEmails($inputString): array
    {
        $pattern = "/\b[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}\b/";

        preg_match_all($pattern, $inputString, $matches);

        return $matches[0];
    }

    public function getEmails(): array
    {
        return $this->emails;
    }

    public function run(string $email): string
    {
        $result = (new EmailValidator())->check($email);
        return $result ? "Email is valid" : 'Email is not valid';
    }
}
