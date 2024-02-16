<?php

# (()()()())((((()()()))(()()()(((())))))) - валидная строка
# (()()()()))((((()()()))(()()()(((())))))) - невалидная строка

$string = $_POST['string'] ?? null;

// Проверить можно curl -X GET http://mysite.local/
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Only POST allowed" . PHP_EOL;
    return;
}

// Проверить можно curl -X POST http://mysite.local/ -d "string="
if (empty($string)) {
    http_response_code(400);
    echo "Body param 'string' required" . PHP_EOL;
    return;
}

$parenthesesCounter = 0;

foreach (str_split($string) as $char) {
    if ($char === '(') {
        $parenthesesCounter++;
    } elseif ($char === ')') {
        $parenthesesCounter--;
        // Проверить можно curl -X POST http://mysite.local/ -d "string=())"
        if ($parenthesesCounter < 0) {
            http_response_code(400);
            echo "Строка плохая" . PHP_EOL;
            return;
        }
    } else {
        // Проверить можно curl -X POST http://mysite.local/ -d "string=() )"
        http_response_code(400);
        echo "Unexpected char in string. Only '(' and ')' allowed" . PHP_EOL;
        return;
    }
}

// Проверить можно curl -X POST http://mysite.local/ -d "string=((())(()()()))"
if ($parenthesesCounter === 0) {
    http_response_code(200);
    echo "Строка хорошая" . PHP_EOL;
} else { // Проверить можно curl -X POST http://mysite.local/ -d "string=()("
    http_response_code(400);
    echo "Строка плохая" . PHP_EOL;
}
return;
