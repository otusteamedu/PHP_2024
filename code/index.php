<?php

declare(strict_types=1);


echo "Контейнер nginx: {$_SERVER['HOSTNAME']}<br><br>";

$inputString = $_POST['string'] ?? null;

if (empty($inputString)) {
    echo "Параметр `string` не передан или пустой";
    exit;
}

$openedBrackets = $closedBrackets = 0;
for ($i = 0; $i < strlen($inputString); $i++) {
    if ($inputString[$i] == '(') {
        $openedBrackets++;
    } elseif ($inputString[$i] == ')') {
        $closedBrackets++;
    } else {
        echo "Параметр `string` содержит некорректные символы.";
        exit;
    }
}

if ($openedBrackets == $closedBrackets) {
    echo "Параметр `string` содержит корректное количество открытых и закрытых скобок.";
} else {
    echo "В параметр `string` количество открытых и закрытых скобок не совпадает.";
}
