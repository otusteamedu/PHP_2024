<?php

echo 'container id: ' . $_SERVER['HOSTNAME'];

if (!empty($_POST['string'])) {
    if (isStringValid($_POST['string'])) {
        http_response_code(200);
        echo 'String is valid!';
    } else {
        throwErrorMessageCode('String is not valid!');
    }
} else {
    throwErrorMessageCode('String is empty!');
}

function isStringValid(string $string): bool
{
    $count = 0;

    for ($i = 0; $i < strlen($string); $i++) {
        if ($string[$i] === '(') {
            $count++;
        } else if ($string[$i] === ')') {
            $count--;
        }

        if ($count < 0) {
            return false;
        }
    }

    if ($count === 0) {
        return true;
    }

    return false;
}

function throwErrorMessageCode(string $msg): void
{
    http_response_code(400);
    throw new Exception($msg);
}
