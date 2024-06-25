<?php

namespace HW4;

require 'validate.php';

class App
{
    public function run(string $str): void
    {
        if ($_POST['string'] == "") {
            echo 'no value';
        } else {
            $isValid = isValid($str);
            if ($isValid) {
                echo "string is valid";
            } else {
                header('HTTP/1.1 400');
                echo "string is not valid";
            }
        }
    }
}
