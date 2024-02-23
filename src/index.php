<?php

declare(strict_types=1);

try {
    if (empty($_POST["string"])) {
        throw new Exception("параметр `string` не передан или пустой");
    }
    $string = $_POST["string"];
    $count = mb_strlen($string);

    if ($string["0"] !== "(" || $string[--$count] !== ")") {
        throw new Exception("неверный формат строки");
    }
    $stack = [];

    for ($i = 0; $i <= $count; $i++) {
        if ($string[$i] === "(") {
            $stack[] = $string[$i];
            continue;
        }

        if ($string[$i] === ")" && !empty($stack)) {
            array_pop($stack);
        } else {
            throw new Exception("неверный формат строки");
        }
    }

    if (!empty($stack)) {
        throw new Exception("неверный формат строки");
    }
    echo "Всё ok";
} catch (Throwable $e) {
    http_response_code(400);
    echo "Всё плохо, \n";
    echo $e->getMessage();
}