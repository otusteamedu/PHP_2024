<?php

namespace src\Check;

class Email
{
    protected array $arrayOfEmails = [
        'some@mail.ru',
        '@email.ru',
        'some@email',
        'som--asd---a_asde@mail.ru',
    ];
    protected string $lineSeparator = '<br>';

    public function __construct(array $emails = [])
    {
        if (!empty($emails)) {
            $this->arrayOfEmails = $emails;
        }
    }

    public function getEmailCheckResult()
    {
        $code = '';
        foreach ($this->arrayOfEmails as $email) {
            $code .= "Validate result for email {$email} is: " . (int)\src\Validator\Email::validate($email) . $this->lineSeparator;
        }

        return $code;
    }
}
