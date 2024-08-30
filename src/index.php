<?php
$hostname = gethostname();
header('Content-Type: text/plain');
echo "Имя хоста: " . $hostname . PHP_EOL;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['string']) && !empty(trim($_POST['string']))) {
        $string = trim($_POST['string']);
        if (isValidString($string)) {
            http_response_code(200);
            echo 'Строка действительна.';
            echo PHP_EOL;
        } else {
            http_response_code(400);
            echo 'Строка недействительна.';
            echo PHP_EOL;
        }
    } else {
        http_response_code(400);
        echo 'Строковый параметр отсутствует или пуст.';
        echo PHP_EOL;
    }
} else {
    http_response_code(405);
    echo 'Метод не разрешен.';
    echo PHP_EOL;
}

function isValidString($str) {
    $stack = [];
    foreach (str_split($str) as $char) {
        if ($char === '(') {
            array_push($stack, $char);
        } elseif ($char === ')') {
            if (empty($stack)) {
                return false;
            }
            array_pop($stack);
        }
    }
    return empty($stack);
}
