<?php

declare(strict_types=1);

namespace AnatolyShilyaev\App;

use AnatolyShilyaev\App\Emails;

class App
{
    private array $emails;

    public function __construct()
    {
        $this->emails = (new Emails())->extract($_POST['string']);
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
