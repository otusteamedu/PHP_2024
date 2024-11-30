<?php

declare(strict_types=1);

namespace AnatolyShilyaev\App;

use AnatolyShilyaev\App\Pattern;

class EmailValidator
{
    public function check($email): bool
    {
        return $this->isFormatCorrect($email) && $this->hasMx($email);
    }

    private function isFormatCorrect($email): bool
    {
        $pattern = (new Pattern)->getPattern();

        if (empty($email)) {
            return false;
        }

        return preg_match($pattern, $email) == 1;
    }

    private function hasMx($email): bool
    {
        $domain = substr(strrchr($email, "@"), 1);
        return checkdnsrr($domain, 'MX');
    }
}
