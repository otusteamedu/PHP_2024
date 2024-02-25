<?php

declare(strict_types=1);

$strOfBraces = $_POST['string'] ?? null;
if ($strOfBraces === null) {
    http_response_code(400);
    echo 'Требуется строка в post-параметре string.';
    return;
}

$strOfBraces = trim($strOfBraces);
if ('' === $strOfBraces) {
    http_response_code(400);
    echo 'Передана пустая строка.';
    return;
}

$isCorrect = true;
$correctCharsOnly = true;
$countOpenedBraces = 0;
for ($index = 0; $index < strlen($strOfBraces); $index++) {
    $char = $strOfBraces[$index];
    if ($char === '(') {
        $countOpenedBraces++;
    } elseif ($char === ')') {
        $countOpenedBraces--;
        if ($countOpenedBraces < 0) {
            break;
        }
    } else {
        $correctCharsOnly = false;
        break;
    }
}

if (!$correctCharsOnly) {
    http_response_code(400);
    echo 'В строке посторонние символы.';
    return;
}

$isCorrect = (0 === $countOpenedBraces);
if ($isCorrect) {
    http_response_code(200);
    echo 'Все ОК.';
} else {
    http_response_code(400);
    echo 'Ошибка в расстановке скобок.';
}
