<?php

use ValidatorBrackets\Validator;

include __DIR__ . '/../Validator.php';

if (isset($_POST['string'])) {
    Validator::validate($_POST['string']);
}

echo PHP_EOL . PHP_EOL . "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];
