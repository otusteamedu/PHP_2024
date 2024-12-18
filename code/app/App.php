<?php

namespace App;

class App
{
    public function run(): void {
        $emails = [
            "google.com",
            "valid@email.uk",
            "fake-email",
            "test@google.com"
        ];

        $validator = new EmailValidator();

        foreach ($emails as $email) {
            $isValid = $validator->validateEmail($email);
            echo $email . ' is ' . ($isValid ? 'valid' : 'invalid') . PHP_EOL;
        }
    }
}