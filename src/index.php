<?php

declare(strict_types=1);

function checkStringBrackets(): bool
{
    $result = false;

    if (!empty($_POST['string'])) {
        $regExp = '/^[^()\n]*+(\((?>[^()\n]|(?1))*+\)[^()\n]*+)++$/m';
        preg_match($regExp, $_POST['string'], $matches);
        $result = count($matches) !== 0;
    }

    return $result;
}

if (!checkStringBrackets()) {
    http_response_code(400);
    throw new Exception("Bad request");
}

http_response_code(200);
echo "true";

