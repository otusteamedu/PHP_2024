<?php

declare(strict_types=1);

class CheckEmails
{
    public function check(string $email): bool{
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //"Good e-mail format"
            $hostmane = explode('@', $email)[1];           
            return checkdnsrr($hostname, "MX"); //checkdns
        }
        else return false; //"Invalid email format";       
    }
}    

    