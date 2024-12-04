<?php

declare(strict_types=1);

use EmailValidation\ValidatorFactory;

$autoloadPathFirst = __DIR__ . '/../../../autoload.php';
$autoloadPathSecond = __DIR__ . '/../vendor/autoload.php';

if (file_exists($autoloadPathFirst)) {
    require_once $autoloadPathFirst;
} else {
    require_once $autoloadPathSecond;
}

$validator = new ValidatorFactory();

$result = $validator->emailValidator()->isValid('email@ya.ru');

echo json_encode($result);
