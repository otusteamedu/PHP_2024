<?php

declare(strict_types=1);

namespace TimurShakirov\EmailValidator;

use Exception;

class EmailValidator
{
    private $reg = "/^[a-z0-9!#$%&'*+\\/=?^_`{|}~-]+(?:\\.[a-z0-9!#$%&'*+\\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/"; 

    public function validateEmail(string $email):bool {
        return $this->regValidate($email) ? $this->dnsValidate($email) : false;
    }

    private function regValidate(string $email):bool
    {
        return (bool)preg_match($this->reg, $email);
    }

    private function dnsValidate(string $email):bool {
        $domain = substr($email, (strpos($email, '@') + 1));
        return checkdnsrr($domain);
    }
}
