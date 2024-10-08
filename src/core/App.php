<?php

namespace Ali;

class App
{
    public array $emailsToCheck;

    public mixed $service;

    public function __construct()
    {
        $this->service = new ValidateEmail();
        $this->emailsToCheck = Email::getEmails();
    }

    public function run(): void
    {
        foreach ($this->emailsToCheck as $email) {
            echo "Email '$email' is " . ($this->service->validate($email) ? 'valid' : 'invalid') . ".\n";
        }
    }

}