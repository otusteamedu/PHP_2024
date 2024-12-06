<?php

declare(strict_types=1);

use EmailValidation\ValidatorFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$validator = new ValidatorFactory();

$result = $validator->emailValidator()->isValid('email@ya.ru');

echo json_encode($result);
