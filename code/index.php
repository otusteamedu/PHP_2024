<?php

declare(strict_types=1);


echo "Контейнер nginx: {$_SERVER['HOSTNAME']}<br><br>";

$inputString = $_POST['string'] ?? null;

if (empty($inputString)) {
    echo "Параметр `string` не передан или пустой";
    exit;
}

$openCount= 0;
for ($i = 0; $i < strlen($inputString); $i++) {
    if ($inputString[$i] == '(') {
        $openCount++;
    } elseif ($inputString[$i] == ')') {
        $openCount--;
    }
    if ($openCount < 0) {
        break;
    }
}

if ($openCount === 0) {
    echo "Параметр `string` содержит корректное количество открытых и закрытых скобок.";
} else {
    echo "В параметре `string` открытые и закрытые скобки не валидны.";
}
