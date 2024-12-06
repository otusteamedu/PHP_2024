<?php

declare(strict_types=1);

namespace ASyrovatkin\Hw5;
class App
{
    private array $testEmails = [
        'asdad@mail.com',
        'asd@mail.com',
        'asadfasfdsd@mailcom',
    ];

    public function run(): string
    {
        $validateEmails = $this->getValidateEmails();
        $validator = new Validator();
        $result = '';
        foreach ($validateEmails as $email) {
            if ($validator->checkEmails($email)) {
                $result .= "Email " . $email . " is valid ". '<br/>';
            } else {
                $result .= "Email " . $email . " is not valid " . '<br/>';
            }
        }

        return $result;

    }

    private function getValidateEmails(): array
    {
        return $this->testEmails;
    }
}