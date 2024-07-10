<?php

namespace src\Check;

class Email
{
    protected array $arrayOfEmails;
    protected string $lineSeparator = '<br>';

    public function __construct(array $emails)
    {
        $this->arrayOfEmails = $emails;
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
