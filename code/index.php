<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method Not Allowed';
    return;
}

$string = $_POST['string'] ?? '';
if ($string === '') {
    http_response_code(400);
    echo 'Empty string';
    return;
}

$stack = [];
foreach (mb_str_split($string) as $char) {
    if ($char === '(') {
        $stack[] = $char;
    } elseif ($char === ')') {
        if (empty($stack)) {
            http_response_code(400);
            echo "Все плохо";
            return;
        }
        array_pop($stack);
    }
}

if (empty($stack)) {
    http_response_code(200);
    echo 'Все хорошо';
} else {
    http_response_code(400);
    echo 'Все плохо';
}
return;

/*
echo "Привет, Otus!<br>".date("Y-m-d H:i:s")."<br><br>";

echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'] . "<br>";

$redis = new Redis();
$redis->connect('redis');

$redis->set('test', 'Hello Redis');
echo $redis->get('test');
*/
