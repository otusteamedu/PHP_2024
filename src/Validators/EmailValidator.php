<?php

declare(strict_types=1);

namespace EmailValidation\Validators;

class EmailValidator implements ValidatorInterface
{
    private string $pattern = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';

    public function isValid(string $email): bool
    {
        return $this->isEmailFormat($email) && $this->isCheckDns($email);
    }
    
    protected function isEmailFormat(string $email): bool
    {
        return (bool)preg_match($this->pattern, $email);
    }

    protected function isCheckDns(string $email): bool
    {
        $mailDomain = substr(strrchr($email, "@"), 1);
        $isValid = checkdnsrr($mailDomain, 'MX');
        
        return $isValid;
    }
}
