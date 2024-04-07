<?php

namespace Irayu\Hw6;

class EmailValidator
{
    public function check(string $email): Result
    {
        $result = new Result();
        if (preg_match('/^[\w\-\\\.]+@([\w\-]+\\.)+[\w\-]{2,4}$/i', $email) != 1) {
            $result->addError(new \ValueError('Email address is not correct.'));
        } else {
            $domain = substr($email, strrpos($email, "@") + 1);

            if (getmxrr($domain, $mxHosts, $mxWeights) === false) {
                $result->addError(new \ValueError('No MX records were found.'));
            } else if (count($mxHosts) == 0 || (count($mxHosts) == 1 && $mxHosts[0] == $domain)) {
                $result->addError(new \ValueError('No active MX records were found.'));
            }
        }

        return $result;
    }
}
