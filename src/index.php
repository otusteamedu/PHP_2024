<?php

declare(strict_types=1);

try {
    if (empty($_REQUEST["string"])) {
        throw new Exception("Не верный параметр");
    }
    $string = $_REQUEST["string"];
    $count = mb_strlen($string);
    if ($string["0"] !== "(" || $string[--$count] !== ")") {
        throw new Exception("Не верный формат строки");
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
            throw new Exception("Не верный формат строки");
        }
    }
    if (!empty($stack)) {
        throw new Exception("Не верный формат строки");
    }
    echo "Строка валидная";
} catch (Exception $e) {
    http_response_code(400);
    echo "Ошибка в запроса скобри не верные или параметры пусты";
}
