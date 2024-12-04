<?php
declare(strict_types=1);

namespace Skudashkin\Hw5;

class CheckEmails
{
    public function check(string $email): bool{
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //"Good e-mail format"
            $hostname = explode('@', $email)[1];           
            return checkdnsrr($hostname, "MX"); //checkdns
        }
        else return false; //"Invalid email format";       
    }
}    

    