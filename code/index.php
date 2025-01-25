<?php

session_start();
phpinfo();
$string = $_POST['string'];


function validateString(string $string): bool
{
    if (empty($string)) {
        return false;
    }

    $count = 0;
    $isBad = false;
    for ($i = 0; $i < strlen($string); $i++) {
        if ($count < 0) {
            return false;

        }
        switch ($string[$i]) {
            case "(":
            {
                $count++;
                break;

            }
            case ")":
            {
                $count--;
                break;

            }
            default:
            {
                return false;
            }
        }
    }

    if ($isBad || $count !== 0) {
        http_response_code(400);
        return false;
    } else {
        return true;
    }
}

if (validateString($string)) {
    echo "Все хорошо";
} else {
    http_response_code(400);
    echo "все плохо";
}

