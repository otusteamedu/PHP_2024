<?php

declare(strict_types=1);

namespace PavelMiasnov\VerificationEmailPhp;

class Verification
{
    public function checkByDefault($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function checkByDns($email)
    {
        $emailBreakDown = explode("@", $email);
        $domain = array_pop($emailBreakDown);
        return $domain && checkdnsrr($domain);
    }
}
