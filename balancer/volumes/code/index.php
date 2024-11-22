<?php

declare(strict_types=1);

if (isset($_POST['string']) && !empty(trim($_POST['string']))) {
    $string = trim($_POST['string']);
    $string = str_replace(' ', '', $string);
    if (str_contains($string, ')') || str_contains($string, '(')) {
        $str_arr = str_split($string);
        $counter = 0;
        foreach ($str_arr as $char) {
            if ($char === '(') {
                $counter++;
            } elseif ($char === ')') {
                $counter--;
            }
        }
        if ($counter === 0) {
            header("HTTP/1.1 200 OK");
            echo 'Правильная скобочная последовательность' . PHP_EOL;
        } else {
            header("HTTP/1.1 400 Bad Request");
            echo 'Все плохо: неправильная скобочная последовательность' . PHP_EOL;
        }
    } else {
        header("HTTP/1.1 400 Bad Request");
        echo 'Все плохо: скобок не обнаружено' . PHP_EOL;
    }
} else {
    header("HTTP/1.1 400 Bad Request");
    echo 'Все плохо: ничего не передали в параметр "string"' . PHP_EOL;
}

