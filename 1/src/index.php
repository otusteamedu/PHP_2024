<?php

$value = $_POST['string'] ?? null;

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(400);
    echo "Только POST" . PHP_EOL;
    return;
}

if (empty($value)) {
    http_response_code(400);
    echo "Строка пустая" . PHP_EOL;
    return;
}

if (!preg_match('/^[()]+$/', $value)) {
    http_response_code(400);
    echo $value;
    echo "Только '(' и ')'" . PHP_EOL;
    return;
}


$openCount = 0;
$closedCount = 0;
foreach (str_split($value) as $char) {
    if ($char === "(") {
        $openCount++;
    } elseif ($char === ")") {
        $closedCount++;
    }
}

if ($openCount === $closedCount) {
    echo "Все супер" . PHP_EOL;
} else {
    http_response_code(400);
    echo "Ошибка числа )(" . PHP_EOL;
}
