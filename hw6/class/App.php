<?php

namespace HW6;

class App
{
    public static function checkEmail()
    {
        $handle = fopen("emails.txt", "r");
        if ($handle) {
            while (($email = fgets($handle)) !== false) {
                $email = str_replace(array("\r", "\n"), '', $email);
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $domain = explode('@', $email);
                    if (getmxrr($domain[1], $mx_records)) {
                        echo $email . ' is valid';
                    } else {
                        echo $email . ' domain is not valid';
                    }
                } else {
                    echo $email . ' is not valid';
                }
                echo "\n";
            }
            fclose($handle);
        }
    }
}
